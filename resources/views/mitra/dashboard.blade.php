@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">
            Dashboard Mitra
        </h2>
        <p class="text-gray-500 mt-1">
            Kelola saldo dan terima order KampusGO 🚀
        </p>
    </div>

    <!-- Saldo -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <div class="bg-gradient-to-br from-green-50 to-white
                    border border-green-200 rounded-2xl p-6 shadow-sm">

            <p class="text-sm text-gray-500 mb-1">
                💰 Saldo Saat Ini
            </p>

            <h3 class="text-3xl font-bold text-green-600">
                Rp {{ number_format($saldo ?? 0) }}
            </h3>

            <p class="text-xs text-gray-500 mt-2">
                Saldo akan terpotong 2% setiap transaksi
            </p>
        </div>

    </div>

    <!-- Order Masuk -->
    <h3 class="text-2xl font-bold text-gray-800 mb-5">
        📥 Order Masuk
    </h3>

    @forelse($orders as $order)
        <div class="bg-white rounded-xl shadow-sm border
                    hover:shadow-md transition mb-5">

            <div class="p-5 grid md:grid-cols-3 gap-4 items-center">

                <!-- Info Order -->
                <div class="md:col-span-2">
                    <span class="inline-block mb-1 text-xs font-semibold
                        {{ $order->service_type === 'ride'
                            ? 'text-blue-600'
                            : 'text-green-600' }}">
                        {{ $order->service_type === 'ride' ? '🚕 Antar Jemput' : '🛒 Jasa Titip' }}
                    </span>

                    <p class="font-semibold text-gray-800">
                        {{ $order->pickup_address }}
                        <span class="mx-1">→</span>
                        {{ $order->destination_address }}
                    </p>

                    @if($order->service_type === 'jastip' && $order->item_description)
                        <p class="text-sm text-gray-500 mt-1">
                            🧾 {{ $order->item_description }}
                        </p>
                    @endif
                </div>

                <!-- Harga & Aksi -->
                <div class="flex md:flex-col justify-between items-end gap-4">

                    <div class="text-right">
                        <p class="text-xs text-gray-500">Tarif</p>
                        <p class="text-lg font-bold text-green-600">
                            Rp {{ number_format($order->price) }}
                        </p>
                    </div>

                    <form method="POST"
                          action="{{ route('mitra.order.accept', $order->id) }}">
                        @csrf
                        <button
                            class="bg-green-600 hover:bg-green-700
                                   text-white px-5 py-2 rounded-full
                                   text-sm font-semibold shadow transition">
                            Terima Order ✔
                        </button>
                    </form>

                </div>

            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl p-8 text-center shadow-sm">
            <p class="text-gray-500">
                📭 Belum ada order masuk
            </p>
        </div>
    @endforelse

</div>
@endsection
