@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold mb-6">📄 Riwayat Pesanan</h2>

    @forelse ($orders as $order)
        <div class="bg-white p-5 rounded-xl shadow-sm mb-4 border">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                {{-- LEFT --}}
                <div>
                    <p class="font-semibold text-lg">
                        {{ strtoupper($order->service_type) }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        📍 {{ $order->pickup_address }}
                        <span class="mx-1">→</span>
                        {{ $order->destination_address }}
                    </p>

                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                        <p>
                            👤 Driver:
                            <span class="font-medium">
                                {{ optional($order->mitra)->name ?? '-' }}
                            </span>
                        </p>

                        <p>
                            💳 Pembayaran:
                            <span class="font-medium capitalize">
                                {{ $order->payment_method }}
                            </span>
                        </p>

                        <p>
                            🕒 Waktu:
                            <span class="font-medium">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="text-right">
                    <p class="font-bold text-xl text-blue-600">
                        Rp {{ number_format($order->price) }}
                    </p>

                    <span
                        class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status === 'pending')
                            bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'accepted')
                            bg-blue-100 text-blue-700
                        @elseif($order->status === 'arrived')
                            bg-purple-100 text-purple-700
                        @elseif($order->status === 'on_the_way')
                            bg-indigo-100 text-indigo-700
                        @elseif($order->status === 'completed')
                            bg-green-100 text-green-700
                        @elseif($order->status === 'rejected')
                            bg-red-100 text-red-700
                        @endif
                        "
                    >
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>

            </div>

        </div>
    @empty
        <p class="text-gray-500 text-center">
            Belum ada pesanan 🚕
        </p>
    @endforelse

</div>
@endsection
