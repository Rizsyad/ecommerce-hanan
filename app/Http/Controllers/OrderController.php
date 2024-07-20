<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user','orderItems'])->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function detail($invoice)
    {
        $order = Order::with(['user','orderItems'])->where('order_number', $invoice)->first();
        if(!$order) {
            return back()->withErrors(['msg' => 'Order not found']);
        }
        return view('orders.detail', compact('order'));
    }

    public function updateStatus(Request $request, string $order_number)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $order = Order::where('order_number', $order_number)->first();
        if(!$order) {
            return back()->withErrors(['msg' => 'Order not found']);
        }

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back();
    }
}
