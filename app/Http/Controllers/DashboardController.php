<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('user')) {
            abort(403);
        }

        $data['orderSalesToday'] = Order::where('ordered_at', '=', Carbon::today())->count();

        $data['orderTrackingStatus'] = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        $data['categoriesCount'] = Category::count();
        $data['productCount'] = Product::count();

        return view('dashboard.index', compact('data'));
    }

    public function transaction()
    {
        $data['transactions'] = Order::with(['user', 'products'])->where('status', 'completed')->latest()->get();
        dd($data['transactions']);
        return view('dashboard.transaction',compact('data'));
    }
}
