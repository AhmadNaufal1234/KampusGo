<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MitraOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Order yang sedang berjalan (hanya satu)
        $activeOrder = Order::with('user')
            ->where('mitra_id', auth()->id())
            ->where('status', 'accepted')
            ->first();


        // Order yang masih menunggu driver
        $pendingOrders = Order::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mitra.dashboard', compact('activeOrder', 'pendingOrders'));
    }

    /**
     * Terima order (JANGAN langsung completed)
     */
    public function accept(Order $order)
    {
        // Set order jadi diterima & simpan driver
        $order->update([
            'status'   => 'accepted',
            'mitra_id' => auth()->id(),
        ]);

        // Potong saldo 2%
        $komisi = $order->price * 0.02;
        auth()->user()->decrement('balance', $komisi);

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Order berhasil diterima');
    }

    /**
     * Selesaikan order (baru potong saldo)
     */
    public function complete(Order $order)
    {
        if ($order->status !== 'accepted') {
            return back()->with('error', 'Order belum bisa diselesaikan.');
        }

        // Potong komisi 2%
        $komisi = $order->price * 0.02;

        $mitra = auth()->user();
        $mitra->balance -= $komisi;
        $mitra->save();

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Order berhasil diselesaikan.');
    }

    /**
     * Tolak order
     */
    public function reject($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak bisa ditolak.');
        }

        $order->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Order berhasil ditolak.');
    }
}