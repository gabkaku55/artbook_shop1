<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $cartItems = [];
        foreach($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $price = $product->converted_price;
                $subtotal += $price * $details['quantity'];
                $cartItems[$id] = [
                    'id' => $id,
                    'name' => $product->translated_name,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'stock' => $product->stock,
                    'formatted_price' => $product->formatted_price,
                    'image' => $product->image,
                    'slug' => $product->slug
                ];
            }
        }
        $shippingCost = ShippingService::getCost($subtotal, 'Nova Poshta');
        $total = $subtotal + $shippingCost;
        return view('shop.cart', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function add(Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Товар закінчився на складі.');
        }
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])) {
            $currentQty = $cart[$product->id]['quantity'];
            if ($currentQty >= $product->stock) {
                return redirect()->back()->with('error', 'Більше немає на складі.');
            }
            $cart[$product->id]['quantity'] = $currentQty + 1;
        } else {
            $cart[$product->id] = [
                "id" => $product->id,
                "quantity" => 1
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар додано до кошика!');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$data['id']])) {
            return response()->json(['success' => false], 404);
        }
        $product = Product::find($data['id']);
        if (!$product) {
            return response()->json(['success' => false], 404);
        }

        if ($data['quantity'] > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Більше немає на складі',
                'max' => $product->stock,
                'current' => $cart[$data['id']]['quantity'],
            ], 422);
        }
        $cart[$data['id']]['quantity'] = $data['quantity'];
        session()->put('cart', $cart);
        $subtotal = 0;
        $itemTotal = 0;
        foreach ($cart as $id => $details) {
            $p = Product::find($id);
            if (!$p) {
                continue;
            }
            $price = $p->converted_price;
            $lineTotal = $price * $details['quantity'];
            $subtotal += $lineTotal;

            if ((int)$id === (int)$data['id']) {
                $itemTotal = $lineTotal;
            }
        }
        $shippingCost = ShippingService::getCost($subtotal, 'Nova Poshta');
        $total = $subtotal + $shippingCost;
        return response()->json([
            'success' => true,
            'item_total' => $itemTotal,
            'subtotal' => $subtotal,
            'shipping' => $shippingCost,
            'total' => $total,
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Товар видалено з кошика!');
    }
}
