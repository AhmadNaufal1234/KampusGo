<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function create()
    {
        return view('customer.order-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|in:ride,jastip',
            'pickup_address' => 'required',
            'destination_address' => 'required',
            'distance_km' => 'required|numeric',
            'payment_method' => 'required|in:cash,ewallet'
        ]);

        // Tarif sederhana
        $tarifPerKm = 3000;
        $price = $request->distance_km * $tarifPerKm;

        Order::create([
            'customer_id' => auth()->id(),
            'service_type' => $request->service_type,
            'pickup_address' => $request->pickup_address,
            'destination_address' => $request->destination_address,
            'item_description' => $request->item_description,
            'distance_km' => $request->distance_km,
            'price' => $price,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        return redirect('/customer/dashboard')->with('success', 'Order berhasil dibuat');
    }

    public function history()
    {
        $orders = Order::where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.order-history', compact('orders'));
    }

    public function cancel(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan');
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
