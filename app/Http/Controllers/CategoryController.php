<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_category' => 'required|min:3|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name_category' => $request->name_category,
            'slug' => Str::slug($request->name_category),
            'image' => $img
        ]);

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'name_category' => 'required|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $imgPath = $request->file('image')->store('categories', 'public');
        } else {
            $imgPath = $category->image;
        }

        $category->update([
            'name_category' => $request->name_category,
            'slug' => Str::slug($request->name_category),
            'image' => $imgPath,
        ]);

        return redirect()->route('dashboard.categories.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return redirect()->route('dashboard.categories.index');
    }
}
