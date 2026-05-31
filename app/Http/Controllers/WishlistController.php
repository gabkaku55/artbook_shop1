<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()->with('product.category')->get();
        return view('user.wishlist', compact('wishlistItems'));
    }

    public function add(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Будь ласка, увійдіть, щоб додати товар у бажане.');
        }
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);
        return back()->with('success', 'Товар додано в бажане.');
    }
    public function remove(Product $product)
    {
        auth()->user()->wishlist()->where('product_id', $product->id)->delete();
        return back()->with('success', 'Товар видалено з бажаного.');
    }
}
