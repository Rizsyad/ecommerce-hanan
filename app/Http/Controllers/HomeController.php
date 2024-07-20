<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReviews;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['products'] = Product::latest()->limit(8)->get();
        
        $data['categories'] = Category::select('id', 'name_category')->latest()->get();
        $data['homeCategories'] = Category::withCount('products')->latest()->limit(4)->get();
        return view('index', compact('data'));
    }

    public function shop()
    {
        $header = [
            "title" => "Our Shop",
            "menu" => "Shop"
        ];

        $data =  [
            "header" => $header
        ];

        $search = request()->input('search');
        $sort = request()->input('sort');

        $data['products'] = Product::query();

        if ($search) {
            $data['products'] = $data['products']->where('name_product', 'like', '%' . $search . '%');
        }

        if ($sort) {
            if ($sort === 'asc') {
                $data['products'] = $data['products']->orderBy('price', 'asc');
            } elseif ($sort === 'desc') {
                $data['products'] = $data['products']->orderBy('price', 'desc');
            } elseif ($sort === 'rating') {
                $data['products'] = $data['products']->orderBy('rating', 'desc'); 
            } else {
                $data['products'] = $data['products']->latest();
            }
        }

        $data['products'] = $data['products']->paginate(12);

        // $data['products'] = Product::latest()->get();
        $data['categories'] = Category::select('id', 'name_category')->latest()->get();


        return view('shop', compact('data'));
    }

    public function shopDetail(Request $request)
    {
        $header = [
            "title" => "SHOP DETAIL",
            "menu" => "Shop Detail"
        ];

        $data =[
            "header" =>$header
        ];

        $data['product'] = Product::with('images', 'category','reviews')->withCount('reviews')->where('slug', $request->slug)->first();
        if(!$data['product']) {
            abort(404);
        }
        $data['avgRating'] = $data['product']->reviews->avg('rating');
        $data['productsWithoutSlug'] = Product::where('slug', '!=', $data['product']->slug)->get();
        $data['userReviews'] = ProductReviews::where('product_id', $data['product']->id)->where('user_id', auth()->user()->id)->with('user')->get();

        $data['categories'] = Category::select('id', 'name_category')->latest()->get();

        return view('shop-details', compact('data'));
    }
    public function productReview(Request $request, string $id)
    {
        $request->validate([
            'rating'=> 'required|digits_between:1,5',
            'review' => 'required',
        ]);

        $product = Product::find($id);
        $product->reviews()->create([
            'user_id' => auth()->user()->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->back();
    }

    public function cart()
    {
        $header = [
            "title" => "Cart",
            "menu" => "Cart"
        ];

        $data = (object) [
            "header" => (object) $header
        ];

        return view('cart', compact('data'));
    }

    public function checkout()
    {
        $header = [
            "title" => "checkout",
            "menu" => "checkout"
        ];

        $data = (object) [
            "header" => (object) $header
        ];

        return view('checkout', compact('data'));
    }
}
