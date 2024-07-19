<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function shop()
    {
        $header = [
            "title" => "Our Shop",
            "menu" => "Shop"
        ];

        $data = (object) [
            "header" => (object) $header
        ];


        return view('shop', compact('data'));
    }

    public function shopDetail(Product $product)
    {
        $header = [
            "title" => "SHOP DETAIL",
            "menu" => "Shop Detail"
        ];

        $data = (object) [
            "header" => (object) $header
        ];

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
