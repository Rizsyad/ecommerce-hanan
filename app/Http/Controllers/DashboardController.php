<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('user')) {
            abort(403);
        }

        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
      

        $orderSalesToday = Order::whereDate('created_at', Carbon::today())->where('status', 'completed')->count();

        $totalAmountMonthly = Order::whereBetween('created_at', [$startMonth, $endMonth])->where('status', 'completed')->sum('total_amount');
        $totalOrderMonthly = Order::whereBetween('created_at', [$startMonth, $endMonth])->where('status', 'completed')->count();
        $productSold = OrderItems::whereHas('order', function ($query) use ($startMonth, $endMonth) {
            $query->whereBetween('created_at', [$startMonth, $endMonth])->where('status', 'completed');
        })->    whereBetween('created_at', [$startMonth, $endMonth])->sum('quantity');

        $profitSaleThisMonth = OrderItems::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('amount');

        $orderTrackingStatus = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $data = [
            'orderSalesToday' => $orderSalesToday,
            'orderTrackingStatus' => $orderTrackingStatus,
            'totalAmountMonthly' => $totalAmountMonthly,
            'totalOrderMonthly' => $totalOrderMonthly,
            'productSold' => $productSold
        ];

        $orders = Order::with(['user', 'orderItems'])
        ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
        ->orderBy('created_at', 'asc')
        ->get();       
        return view('dashboard.index', compact('data', 'orders'));
    }

    public function transaction()
    {
        $data['transactions'] = Order::with(['user', 'orderItems'])->latest()->get();
        return view('dashboard.transaction',compact('data'));
    }
}
