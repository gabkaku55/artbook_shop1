<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if ($request->boolean('abandon_bank')) {
            session()->forget('pending_bank_checkout');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній.');
        }

        [$cartItems, $subtotal] = $this->buildCartItemsAndSubtotal($cart);

        [$discountPercentage, $discountAmount, $afterDiscount] = $this->calculateDiscounts($subtotal);

        $shippingNovaPoshta = ShippingService::getCost($subtotal, 'Nova Poshta');
        $shippingUkrposhta = ShippingService::getCost($subtotal, 'Ukrposhta');
        $freeThreshold = ShippingService::FREE_DELIVERY_THRESHOLD;

        return view('shop.checkout', compact('cartItems', 'subtotal', 'discountPercentage', 'discountAmount', 'afterDiscount', 'shippingNovaPoshta', 'shippingUkrposhta', 'freeThreshold'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^380[0-9]{9}$/',
            'address' => 'required|string|max:500',
            'zip_code' => 'required|string|max:20',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home');
        }

        [$itemsToStore, $total] = $this->buildOrderItemsAndTotal($cart);

        [$discountPercentage, $discountAmount, $subtotal] = $this->calculateDiscounts($total);

        $shippingCost = ShippingService::getCost($subtotal, $request->shipping_method);
        $totalPrice = $subtotal + $shippingCost;
        $normalizedShipping = ShippingService::normalizeMethod($request->shipping_method);

        if ($request->payment_method === 'bank') {
            session()->put('pending_bank_checkout', [
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'shipping_method' => $normalizedShipping,
                'itemsToStore' => $itemsToStore,
                'subtotal' => $subtotal,
                'discountAmount' => $discountAmount,
                'shippingCost' => $shippingCost,
                'totalPrice' => $totalPrice,
            ]);
            return redirect()->route('checkout.bank-details');
        }

        DB::beginTransaction();
        try {
            $status = 'pending';

            $order = Order::create([
                'user_id' => auth()->id(),
                'shipping_cost' => $shippingCost,
                'total_price' => $totalPrice,
                'discount_amount' => $discountAmount,
                'status' => $status,
                'shipping_method' => $normalizedShipping,
                'payment_method' => $request->payment_method,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
            ]);

            foreach ($itemsToStore as $item) {
                $order->items()->create($item);
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            if ($request->payment_method === 'online') {
                return redirect()->route('payment', $order->id);
            }

            return redirect()->route('payment.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Щось пішло не так: ' . $e->getMessage());
        }
    }

    public function showBankDetails()
    {
        $data = session()->get('pending_bank_checkout');
        if (!$data) {
            return redirect()->route('checkout')->with('error', __('messages.bank_details_expired'));
        }

        $bankDetails = $this->buildBankDetails(__('messages.bank_purpose_generic'));
        return view('shop.bank-details', compact('bankDetails'));
    }

    public function submitBankReceipt(Request $request)
    {
        $this->validateReceipt($request);

        $data = session()->get('pending_bank_checkout');
        if (!$data) {
            return redirect()->route('checkout')->with('error', __('messages.bank_details_expired'));
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout')->with('error', __('messages.cart_empty'));
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'shipping_cost' => $data['shippingCost'],
                'total_price' => $data['totalPrice'],
                'discount_amount' => $data['discountAmount'],
                'status' => 'pending',
                'shipping_method' => $data['shipping_method'],
                'payment_method' => 'bank',
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'zip_code' => $data['zip_code'],
            ]);

            $this->handleReceiptUpload($request, $order);

            foreach ($data['itemsToStore'] as $item) {
                $order->items()->create($item);
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('pending_bank_checkout');
            session()->forget('cart');

            return redirect()->route('payment.success', $order->id)->with('success', __('messages.receipt_uploaded'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Щось пішло не так: ' . $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending' || $order->payment_method !== 'online') {
            return redirect()->route('home');
        }
        return view('shop.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        $request->validate([
            'card_number' => 'required|digits:16',
            'expiry' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|digits:3',
            'cardholder' => 'required|string|max:255',
        ]);

        $order->update(['status' => 'paid']);

        return redirect()->route('payment.success', $order->id);
    }

    public function success(Order $order)
    {
        $bankDetails = $this->buildBankDetails('Оплата замовлення #' . $order->id);
        return view('shop.payment-success', compact('order', 'bankDetails'));
    }

    public function uploadReceipt(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validateReceipt($request);
        $this->handleReceiptUpload($request, $order);

        return back()->with('success', __('messages.receipt_uploaded'));
    }

    public function cancelOrder(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            return back()->with('error', 'Це замовлення не можна скасувати.');
        }

        $order->load('items');

        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $backToCheckout = $request->input('redirect_after_cancel') === 'checkout';
        if ($backToCheckout) {
            $cart = [];
            foreach ($order->items as $item) {
                $cart[$item->product_id] = [
                    'id' => $item->product_id,
                    'quantity' => $item->quantity,
                ];
            }
            session()->put('cart', $cart);
        }

        $order->update(['status' => 'cancelled']);

        if ($backToCheckout) {
            return redirect()->route('checkout')->with('success', __('messages.checkout_payment_abandoned'));
        }

        return back()->with('success', 'Замовлення успішно скасовано.');
    }

    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product']);

        return view('shop.order-show', compact('order'));
    }

    private function buildCartItemsAndSubtotal(array $cart): array
    {
        $subtotal = 0;
        $cartItems = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product) {
                continue;
            }

            $price = $product->converted_price;
            $subtotal += $price * $details['quantity'];

            $cartItems[$id] = [
                'name' => $product->translated_name,
                'quantity' => $details['quantity'],
                'price' => $price,
            ];
        }

        return [$cartItems, $subtotal];
    }

    private function buildOrderItemsAndTotal(array $cart): array
    {
        $total = 0;
        $itemsToStore = [];
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if (!$product) {
                continue;
            }
            $price = $product->converted_price;
            $total += $price * $details['quantity'];
            $itemsToStore[] = [
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $price,
            ];
        }

        return [$itemsToStore, $total];
    }

    private function calculateDiscounts(float $baseAmount): array
    {
        $discountPercentage = auth()->check() ? auth()->user()->discount_percentage : 0;
        $discountAmount = ($baseAmount * $discountPercentage) / 100;
        $afterDiscount = $baseAmount - $discountAmount;
        return [$discountPercentage, $discountAmount, $afterDiscount];
    }

    private function buildBankDetails(string $purpose): array
    {
        return [
            'iban' => 'UA78 3052 9900 0002 6001 2345 6789',
            'receiver' => 'ФОП Книжковий Магазин Артбуків',
            'edrpou' => '12345678',
            'purpose' => $purpose,
        ];
    }

    private function validateReceipt(Request $request): void
    {
        $request->validate([
            'receipt' => 'required|file|mimetypes:image/jpeg,image/png,image/webp,application/pdf|max:5120',
        ], [
            'receipt.required' => __('messages.receipt_required'),
            'receipt.mimetypes' => __('messages.receipt_mime'),
            'receipt.max' => __('messages.receipt_max'),
        ]);
    }

    private function handleReceiptUpload(Request $request, Order $order): void
    {
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $order->update(['receipt_image' => $path]);
        }
    }
}
