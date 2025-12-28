<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class MitraOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'pending')->get();
        return view('mitra.dashboard', compact('orders'));
    }

    public function accept(Order $order)
    {
        $order->update([
            'mitra_id' => auth()->id(),
            'status' => 'completed'
        ]);

        // Potong komisi 2%
        $komisi = $order->price * 0.02;

        $mitra = auth()->user();
        $mitra->balance -= $komisi;
        $mitra->save();

        return back()->with('success', 'Order diterima, komisi dipotong 2%');
    }
}