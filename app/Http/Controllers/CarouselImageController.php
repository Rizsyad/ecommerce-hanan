<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarouselImage;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    public function index()
    {
        $carouselImage = CarouselImage::latest()->get();
        return view('carousel-image.index',compact('carouselImage'));
    }

    public function create()
    {
        return view('carousel-image.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $img = $request->file('image')->store('carousel-image', 'public');
        }
        CarouselImage::create([
            'image' => $img
        ]);
        return redirect()->route('dashboard.carouselImage.index');
    }

    public function destroy(string $id)
    {
        $carouselImage = CarouselImage::where('id', $id)->first();
        if(!$carouselImage) {
            abort(404);
        }
        if ($carouselImage->image) {
            Storage::disk('public')->delete($carouselImage->image);
        }
        $carouselImage->delete();
        return redirect()->route('dashboard.carouselImage.index');
    }
}
