<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'author_en' => 'nullable|string|max:255',
            'author_de' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'pages' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'age_limit' => 'nullable|string|max:255',
            'cover_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_new' => 'sometimes|boolean',
            'is_popular' => 'sometimes|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_new'] = $request->has('is_new');
        $data['is_popular'] = $request->has('is_popular');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Товар створено.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'author_en' => 'nullable|string|max:255',
            'author_de' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_de' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'pages' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'age_limit' => 'nullable|string|max:255',
            'cover_type' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'is_new' => 'sometimes|boolean',
            'is_popular' => 'sometimes|boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['is_new'] = $request->has('is_new');
        $data['is_popular'] = $request->has('is_popular');
        $data['sale_price'] = $request->filled('sale_price') ? (float) $request->sale_price : null;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Товар оновлено.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Товар видалено.');
    }
}

