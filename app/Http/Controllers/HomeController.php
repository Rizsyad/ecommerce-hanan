<?php

namespace App\Http\Controllers;

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
}
