<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductRating;

class DashboardController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();

        $data = [
            'categoriesCount' => $categoriesCount,
            'productsCount' => $productsCount,
        ];

        return view('dashboard.index', $data);
    }
}
