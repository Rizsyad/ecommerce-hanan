<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

        $data['products'] = Product::latest()->get();
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

        $data['product'] = Product::with('images', 'category')->withCount('reviews')->where('slug', $request->slug)->first();
        // dd($data['product']);
        if(!$data['product']) {
            abort(404);
        }
        $data['productsWithoutSlug'] = Product::where('slug', '!=', $request->slug)->get();
        $data['categories'] = Category::select('id', 'name_category')->latest()->get();

        return view('shop-details', compact('data'));
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
