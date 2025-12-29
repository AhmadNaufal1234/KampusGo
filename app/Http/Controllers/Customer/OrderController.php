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
            'service_type'        => 'required|in:ride,jastip',
            'pickup_address'      => 'required|string',
            'destination_address' => 'required|string',
            'distance_km'         => 'required|numeric|min:0.1',
            'payment_method'      => 'required|in:cash,ewallet',
            'item_description'    => 'nullable|string'
        ]);

        // =============================
        // HITUNG TARIF
        // =============================
        $tarifPerKm = 3000;
        $price = $request->distance_km * $tarifPerKm;

        // =============================
        // E-WALLET → CEK & TAHAN SALDO
        // =============================
        if ($request->payment_method === 'ewallet') {

            if (auth()->user()->saldo < $price) {
                return back()->with(
                    'error',
                    'Saldo e-wallet tidak cukup. Silakan top up terlebih dahulu.'
                );
            }

            // TAHAN SALDO (ESCROW)
            auth()->user()->decrement('saldo', $price);
        }

        // =============================
        // BUAT ORDER
        // =============================
        Order::create([
            'customer_id'         => auth()->id(),
            'service_type'        => $request->service_type,
            'pickup_address'      => $request->pickup_address,
            'destination_address' => $request->destination_address,
            'item_description'    => $request->item_description,
            'distance_km'         => $request->distance_km,
            'price'               => $price,
            'payment_method'      => $request->payment_method,
            'payment_status'      => $request->payment_method === 'ewallet'
                ? 'held'   // saldo ditahan sistem
                : null,
            'status'              => 'pending',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Pesanan berhasil dibuat 🚀');
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
        // Pastikan order milik customer
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        // Hanya bisa dibatalkan jika masih pending
        if ($order->status !== 'pending') {
            return back()->with(
                'error',
                'Pesanan tidak bisa dibatalkan karena sudah diproses driver.'
            );
        }

        $order->update([
            'status' => 'rejected'
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}