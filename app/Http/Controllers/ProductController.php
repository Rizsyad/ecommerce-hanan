<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_product' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'required|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imgName = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = Str::slug($validated['name_product']) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imgName);
        }
    
        Product::create([
            'name' => $validated['name_product'],
            'slug' => Str::slug($validated['name_product']),
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'stock' => $validated['stock'],
            'image_url' => $imgName,
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);
        
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name_product' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'required|min:3|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $product = Product::findOrFail($id);
    
        $imgName = $product->image_url;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = Str::slug($validated['name_product']) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imgName);
        }
    
        $product->update([
            'name' => $validated['name_product'],
            'slug' => Str::slug($validated['name_product']),
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'stock' => $validated['stock'],
            'description' => $validated['description'],
            'image_url' => $imgName,
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
