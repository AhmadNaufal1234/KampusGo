@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6">📄 Riwayat Pesanan</h2>

    @forelse ($orders as $order)
        <div class="bg-white p-5 rounded-lg shadow mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold">
                        {{ strtoupper($order->service_type) }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $order->pickup_address }} → {{ $order->destination_address }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-blue-600">
                        Rp {{ number_format($order->price) }}
                    </p>
                    <span class="text-sm px-2 py-1 rounded
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Belum ada pesanan.</p>
    @endforelse
</div>
@endsection
