@extends('layouts.app') @section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- HEADER -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard Mitra</h2>
        <p class="text-gray-500 mt-1">
            Kelola pesanan & komunikasi dengan customer 🚀
        </p>
    </div>

    <!-- SALDO -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">
        <div
            class="bg-gradient-to-br from-green-50 to-white border border-green-200 rounded-2xl p-6 shadow-sm"
        >
            <p class="text-sm text-gray-500 mb-1">💰 Saldo Saat Ini</p>
            <h3 class="text-3xl font-bold text-green-600">
                Rp {{ number_format(auth()->user()->saldo ?? 0) }}
            </h3>
            <p class="text-xs text-gray-500 mt-2">
                Saldo akan terpotong 2% tiap transaksi
            </p>
            <a
                href="{{ route('mitra.topup') }}"
                class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold"
            >
                ➕ Top Up Saldo
            </a>
        </div>
    </div>

    {{-- ================= ORDER AKTIF ================= --}}
    @if($activeOrder)
    <div class="mb-10">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">
            🚗 Order Sedang Berjalan
        </h3>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-sm">
            <p class="text-lg font-semibold text-gray-800">
                👤 Customer:
                {{ optional($activeOrder->user)->name ?? 'Customer' }}
            </p>

            <p class="text-gray-700 mt-1">
                📍 {{ $activeOrder->pickup_address }} →
                {{ $activeOrder->destination_address }}
            </p>

            @if($activeOrder->item_description)
            <p class="text-gray-600 mt-1">
                🧾 {{ $activeOrder->item_description }}
            </p>
            @endif

            <p class="mt-3 font-semibold text-blue-700">
                💰 Tarif: Rp {{ number_format($activeOrder->price) }}
            </p>

            <!-- ANIMASI DRIVER -->
            <div
                class="relative mt-6 h-16 overflow-hidden bg-blue-100 rounded-lg"
            >
                <div
                    class="absolute top-1/2 -translate-y-1/2 animate-drive text-3xl"
                >
                    🛵
                </div>
            </div>

            {{-- AKSI DRIVER --}}
            <div class="mt-5 flex gap-3 flex-wrap">
                @if($activeOrder->status === 'accepted')
                <form
                    method="POST"
                    action="{{ route('mitra.order.arrived', $activeOrder->id) }}"
                >
                    @csrf
                    <button
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold"
                    >
                        📍 Sudah Sampai Jemputan
                    </button>
                </form>
                @endif @if($activeOrder->status === 'arrived')
                <form
                    method="POST"
                    action="{{ route('mitra.order.onway', $activeOrder->id) }}"
                >
                    @csrf
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold"
                    >
                        🚗 Mulai Perjalanan
                    </button>
                </form>
                @endif @if($activeOrder->status === 'on_the_way')
                <form
                    method="POST"
                    action="{{ route('mitra.order.complete', $activeOrder->id) }}"
                    onsubmit="return confirm('Selesaikan pesanan? Saldo akan terpotong 2%');"
                >
                    @csrf
                    <button
                        type="button"
                        id="completeOrderBtn"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold"
                    >
                        ✅ Selesaikan Pesanan
                    </button>
                </form>
                @endif
            </div>

            {{-- CHAT DRIVER --}}
            <div class="mt-6 bg-white border rounded-xl p-4 shadow">
                <h4 class="font-semibold text-gray-700 mb-3">
                    💬 Chat dengan Driver
                </h4>

                <div
                    class="h-56 overflow-y-auto mb-3 space-y-2 bg-gray-50 p-3 rounded"
                >
                    @foreach($activeOrder->messages as $msg)
                    <div
                        class="{{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}"
                    >
                        <div
                            class="inline-block px-3 py-2 rounded-lg 
                    {{ $msg->sender_id == auth()->id() 
                        ? 'bg-blue-600 text-white' 
                        : 'bg-gray-200 text-gray-800' }}"
                        >
                            {{ $msg->message }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <form
                    method="POST"
                    action="{{ route('order.chat.send', $activeOrder->id) }}"
                    class="flex gap-2"
                >
                    @csrf
                    <input
                        type="text"
                        name="message"
                        placeholder="Ketik pesan ke driver..."
                        class="flex-1 border rounded-lg px-3 py-2"
                        required
                    />
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- ================= ORDER MASUK ================= --}}
    <h3 class="text-2xl font-bold text-gray-800 mb-5">📥 Order Masuk</h3>

    @forelse($pendingOrders as $order)
    <div class="bg-white rounded-xl shadow-sm border mb-5">
        <div class="p-5 grid md:grid-cols-3 gap-4 items-center">
            <div class="md:col-span-2">
                <p class="font-semibold text-gray-800">
                    👤 {{ $order->customer->name ?? '-' }}
                </p>

                <p class="text-gray-700">
                    {{ $order->pickup_address }} →
                    {{ $order->destination_address }}
                </p>

                @if($order->item_description)
                <p class="text-sm text-gray-500 mt-1">
                    🧾 {{ $order->item_description }}
                </p>
                @endif
            </div>

            <div class="flex flex-col items-end gap-3">
                <p class="text-lg font-bold text-green-600">
                    Rp {{ number_format($order->price) }}
                </p>

                <div class="flex gap-2">
                    <form
                        method="POST"
                        action="{{ route('mitra.order.accept', $order->id) }}"
                    >
                        @csrf
                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full"
                        >
                            Terima
                        </button>
                    </form>

                    <form
                        method="POST"
                        action="{{ route('mitra.order.reject', $order->id) }}"
                    >
                        @csrf
                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full"
                        >
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl p-8 text-center shadow-sm">
        <p class="text-gray-500">📭 Tidak ada order masuk</p>
    </div>
    @endforelse
</div>

<style>
    @keyframes drive {
        0% {
            left: 110%;
        }
        100% {
            left: -10%;
        }
    }
    .animate-drive {
        position: absolute;
        animation: drive 6s linear infinite;
    }
</style>
<script>
document.getElementById('completeOrderBtn').addEventListener('click', function () {
    Swal.fire({
        title: 'Selesaikan Pesanan?',
        text: 'Pastikan pesanan sudah benar-benar selesai.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Selesaikan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            this.closest('form').submit();
        }
    });
});
</script>

@endsection
