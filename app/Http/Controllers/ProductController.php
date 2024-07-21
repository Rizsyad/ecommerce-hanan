<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
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
        $request->validate([
            'name_product' => 'required|min:3|max:255',
            'price' => 'required|integer|min:1',
            'stock' => 'required|integer|min:1',
            'short_description' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $img = $request->file('image')->store('product', 'public');
        }
    
        Product::create([
            'name_product' => $request->name_product,
            'slug' => Str::slug($request->name_product),
            'price' => $request->price,
            'stock' => $request->stock,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $img
        ]);
        
        return redirect()->route('dashboard.product.index');
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
    public function edit(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if(!$product) {
            abort(404);
        }
        $categories = Category::get();
        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'name_product' => 'required|min:3|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'short_description' => 'required|min:3|max:255',
            'description' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            abort(404);
        }
    
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imgPath = $request->file('image')->store('product', 'public');
        } else {
            $imgPath = $product->image;
        }

    
        $product->update([
            'name_product' => $request->name_product,
            'slug' => Str::slug($request->name_product),
            'price' => $request->price,
            'stock' => $request->stock,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $imgPath
        ]);

        return redirect()->route('dashboard.product.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('dashboard.product.index');
    }

    public function listImage(string $slug)
    {
        $product = Product::with('images')->where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }
        $images = $product->images;
        return view('product.list-image'  , compact('product', 'images'));
    }

    public function addImage(string $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }
        return view('product.add-image', compact('product'));
    }

    public function storeImage(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }
        if ($request->hasFile('image')) {
            $img = $request->file('image')->store('product-multiple', 'public');
        }

        ProductImage::create([
            'product_id' => $product->id,
            'image' => $img
        ]);

        return redirect()->route('dashboard.product.list-image', $product->slug);
    }

    public function deleteImage(string $slug, int $id)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product) {
            abort(404);
        }
        $image = ProductImage::where('id', $id)->first();
        if(!$image) {
            abort(404);
        }
        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();
        return redirect()->route('dashboard.product.list-image', $slug);
    }
}
