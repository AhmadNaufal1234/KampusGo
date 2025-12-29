<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class MitraOrderController extends Controller
{
    public function index()
    {
        $activeOrder = Order::where('mitra_id', auth()->id())
            ->whereNotIn('status', ['completed', 'rejected'])
            ->latest()
            ->first();


        $pendingOrders = Order::where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mitra.dashboard', compact('activeOrder', 'pendingOrders'));
    }

    public function accept(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak tersedia.');
        }

        $order->update([
            'status'   => 'accepted',
            'mitra_id' => auth()->id(),
        ]);

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Order berhasil diterima');
    }

    public function arrived(Order $order)
    {
        if ($order->status !== 'accepted' || $order->mitra_id !== auth()->id()) {
            return back();
        }

        $order->update(['status' => 'arrived']);

        return back()->with('success', 'Sudah sampai di titik jemput');
    }

    public function onWay(Order $order)
    {
        if ($order->status !== 'arrived' || $order->mitra_id !== auth()->id()) {
            return back();
        }

        $order->update(['status' => 'on_the_way']);

        return back()->with('success', 'Perjalanan dimulai');
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'on_the_way' || $order->mitra_id !== auth()->id()) {
            return back()->with('error', 'Order belum bisa diselesaikan.');
        }

        DB::transaction(function () use ($order) {

            $driver = auth()->user();

            // Fee platform 2%
            $fee = $order->price * 0.02;

            // =============================
            // 💳 E-WALLET (ESCROW SYSTEM)
            // =============================
            if ($order->payment_method === 'ewallet') {

                // Uang masuk ke driver (setelah fee)
                $driver->increment('saldo', $order->price - $fee);

                // Tandai pembayaran selesai
                $order->update([
                    'payment_status' => 'released'
                ]);
            }

            // =============================
            // 💵 CASH
            // =============================
            if ($order->payment_method === 'cash') {

                // Driver wajib punya saldo utk fee
                if ($driver->saldo < $fee) {
                    throw new \Exception('Saldo tidak cukup untuk menyelesaikan pesanan.');
                }

                // Potong fee
                $driver->decrement('saldo', $fee);
            }

            // =============================
            // Selesaikan Order
            // =============================
            $order->update([
                'status' => 'completed'
            ]);
        });

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Pesanan selesai.');
    }

    public function reject(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak bisa ditolak.');
        }

        $order->update(['status' => 'rejected']);

        return back()->with('success', 'Order berhasil ditolak.');
    }
}