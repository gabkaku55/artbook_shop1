<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->where('hidden_for_admin', false);
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'bank') {
            $query->orderByRaw("CASE WHEN payment_method = 'bank' THEN 0 ELSE 1 END")->orderBy('created_at', 'desc');
        } elseif ($sort === 'card') {
            $query->orderByRaw("CASE WHEN payment_method IN ('card', 'online') THEN 0 ELSE 1 END")->orderBy('created_at', 'desc');
        } elseif ($sort === 'cod') {
            $query->orderByRaw("CASE WHEN payment_method = 'cod' THEN 0 ELSE 1 END")->orderBy('created_at', 'desc');
        } else {
            $query->latest();
        }
        $orders = $query->paginate(10)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $pm = \App\Enums\OrderStatus::normalizePaymentMethod($order->payment_method);
        $allowed = array_keys(\App\Enums\OrderStatus::allowedStatusesByPayment($pm));
        $request->validate(['status' => 'required|in:' . implode(',', $allowed)]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Статус замовлення оновлено.');
    }

    public function destroy(Order $order)
    {
        $order->update(['hidden_for_admin' => true]);
        return back()->with('success', 'Замовлення видалено з панелі адміна.');
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $users = User::all();
        return view('admin.orders.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'shipping_method' => 'required|string',
        ]);

        $user = User::find($request->user_id);
        $total = 0;
        $items = [];
        foreach ($request->products as $pData) {
            $product = Product::find($pData['id']);
            $total += $product->price * $pData['qty'];
            $items[] = [
                'product_id' => $product->id,
                'quantity' => $pData['qty'],
                'price' => $product->price,
            ];
            $product->decrement('stock', $pData['qty']);
        }
        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => 'Admin Created',
            'total_price' => $total,
            'status' => 'paid',
            'shipping_method' => $request->shipping_method,
        ]);
        foreach ($items as $item) {
            $order->items()->create($item);
        }
        return redirect()->route('admin.orders.index')->with('success', 'Order created.');
    }
}

