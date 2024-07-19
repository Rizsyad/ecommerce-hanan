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
        if (auth()->user()->hasRole('user')) {
            abort(403);
        }
        
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        

        return view('dashboard.index', compact('categoriesCount', 'productsCount'));
    }
}
