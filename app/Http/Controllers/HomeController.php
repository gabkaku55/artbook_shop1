<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\UnboxingVideo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        UnboxingVideo::syncLegacyDefaults();

        $newArrivals = Product::where('is_new', true)->latest()->take(10)->get();
        $popularProducts = Product::where('is_popular', true)->take(10)->get();
        $unboxingVideos = UnboxingVideo::latest()->get();

        return view('pages.home', compact('newArrivals', 'popularProducts', 'unboxingVideos'));
    }

    public function profile()
    {
        $user = auth()->user();
        $orders = $user->orders()->with(['items.product'])->latest()->get();
        return view('user.profile', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Профіль оновлено!');
    }
}
