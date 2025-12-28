@extends('layouts.app') @section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-800">
            Halo, {{ auth()->user()->name }} 👋
        </h2>
        <p class="text-gray-500 mt-2">
            Mau ke mana hari ini? KampusGO siap bantu 🚀
        </p>
    </div>

    {{-- Order Aktif --}}
    @if($activeOrder) @php $statusStyle = match($activeOrder->status) {
    'pending' => 'bg-yellow-50 border-yellow-200', 'accepted' => 'bg-blue-50
    border-blue-200', 'completed' => 'bg-green-50 border-green-200', 'cancelled'
    => 'bg-red-50 border-red-200', default => 'bg-gray-50 border-gray-200', };
    $badgeStyle = match($activeOrder->status) { 'pending' => 'bg-yellow-200
    text-yellow-800', 'accepted' => 'bg-blue-200 text-blue-800', 'completed' =>
    'bg-green-200 text-green-800', 'cancelled' => 'bg-red-200 text-red-800',
    default => 'bg-gray-200 text-gray-800', }; @endphp

    <div class="mb-10">
        <div
            class="border {{ $statusStyle }}
                rounded-2xl p-6 shadow-sm"
        >
            <div class="flex justify-between items-start gap-6">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2 text-lg">
                        🚧 Pesanan Sedang Berjalan
                    </h3>

                    <p class="text-sm text-gray-700">
                        <strong>Layanan:</strong>
                        {{ $activeOrder->service_type === 'ride' ? 'Antar Jemput' : 'Jasa Titip' }}
                    </p>

                    <p class="text-sm text-gray-700">
                        <strong>Dari:</strong>
                        {{ $activeOrder->pickup_address }}
                    </p>

                    <p class="text-sm text-gray-700">
                        <strong>Tujuan:</strong>
                        {{ $activeOrder->destination_address }}
                    </p>

                    <p class="text-sm text-gray-700">
                        <strong>Tarif:</strong>
                        <span class="font-semibold">
                            Rp
                            {{ number_format($activeOrder->price, 0, ',', '.') }}
                        </span>
                    </p>

                    <span
                        class="inline-block mt-3 px-3 py-1 rounded-full
                    text-xs font-semibold {{ $badgeStyle }}"
                    >
                        {{ ucfirst($activeOrder->status) }}
                    </span>
                </div>

                {{-- Cancel Button --}}
                @if($activeOrder->status === 'pending')
                <form
                    method="POST"
                    action="{{ route('customer.order.cancel', $activeOrder->id) }}"
                >
                    @csrf
                    <button
                        type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition"
                    >
                        Batalkan Pesanan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Cards -->
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Antar Jemput -->
        <div
            class="group relative bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
        >
            <div
                class="w-16 h-16 flex items-center justify-center bg-white/70 backdrop-blur text-blue-600 rounded-full text-3xl mb-5 shadow"
            >
                🚕
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Antar Jemput
            </h3>

            <p class="text-sm text-gray-500 mb-6">
                Perjalanan cepat & aman ke kampus, kos, atau tujuan lain.
            </p>

            <a
                href="{{ route('customer.order.create', ['service_type' => 'ride']) }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow transition"
            >
                Pesan Sekarang
                <span class="group-hover:translate-x-1 transition">→</span>
            </a>
        </div>

        <!-- Jasa Titip -->
        <div
            class="group relative bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
        >
            <div
                class="w-16 h-16 flex items-center justify-center bg-white/70 backdrop-blur text-green-600 rounded-full text-3xl mb-5 shadow"
            >
                🛒
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">Jasa Titip</h3>

            <p class="text-sm text-gray-500 mb-6">
                Titip beli makanan, minuman, atau kebutuhan harianmu.
            </p>

            <a
                href="{{ route('customer.order.create', ['service_type' => 'jastip']) }}"
                class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow transition"
            >
                Pesan Sekarang
                <span class="group-hover:translate-x-1 transition">→</span>
            </a>
        </div>

        <!-- Order History -->
        <div
            class="group relative bg-gradient-to-br from-teal-50 to-white border border-teal-100 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition"
        >
            <div
                class="w-16 h-16 flex items-center justify-center bg-white/70 backdrop-blur text-teal-600 rounded-full text-3xl mb-5 shadow"
            >
                📄
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Riwayat Pesanan
            </h3>

            <p class="text-sm text-gray-500 mb-6">
                Lihat status & detail pesanan yang pernah kamu buat.
            </p>

            <a
                href="{{ route('customer.orders.history') }}"
                class="inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow transition"
            >
                Lihat Riwayat
                <span class="group-hover:translate-x-1 transition">→</span>
            </a>
        </div>
    </div>
</div>
@endsection
