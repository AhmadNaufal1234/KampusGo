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

    {{-- ================= ACTIVE ORDER ================= --}}
    @if($activeOrder) @php $driverName = $activeOrder->mitra->name ?? 'Driver';
    @endphp @if($activeOrder->status === 'pending')
    {{-- MENUNGGU DRIVER --}}
    <div class="flex flex-col items-center justify-center text-center mb-14">
        <div class="relative w-40 h-40 mb-6">
            <div
                class="absolute inset-0 rounded-full bg-blue-200 animate-ping opacity-30"
            ></div>
            <div
                class="absolute inset-3 rounded-full bg-blue-300 animate-pulse opacity-40"
            ></div>
            <div
                class="absolute inset-6 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg"
            >
                🚗
            </div>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-2">
            Mencari Driver Terdekat...
        </h3>

        <p class="text-gray-500 mb-4">
            Mohon tunggu, sistem sedang mencarikan driver terbaik 🚀
        </p>

        <span
            class="inline-block px-4 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold mb-6"
        >
            Status: Menunggu Driver
        </span>

        <form
            method="POST"
            action="{{ route('customer.order.cancel', $activeOrder->id) }}"
        >
            @csrf
            <button
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold"
            >
                Batalkan Pesanan
            </button>
        </form>
    </div>

    @elseif($activeOrder->status === 'accepted')

    {{-- DRIVER DALAM PERJALANAN --}}
    <div class="mb-10">
        <div
            class="bg-blue-50 border border-blue-200 rounded-2xl p-6 shadow-sm"
        >
            <h3 class="text-xl font-semibold text-blue-800 mb-2">
                🚗 Driver Sedang Menuju Lokasi
            </h3>

            <p class="text-gray-700 mb-1">
                <strong>Driver:</strong> {{ $driverName }}
            </p>

            <p class="text-gray-700 mb-2">
                <strong>Rute:</strong> {{ $activeOrder->pickup_address }} →
                {{ $activeOrder->destination_address }}
            </p>

            @if($activeOrder->item_description)
            <p class="text-gray-600 mb-3">
                🧾 {{ $activeOrder->item_description }}
            </p>
            @endif

            <!-- ANIMASI JALAN -->
            <div
                class="relative h-16 overflow-hidden rounded-xl bg-blue-100 mb-3"
            >
                <div
                    class="absolute top-1/2 -translate-y-1/2 animate-drive text-3xl"
                >
                    🛵
                </div>
            </div>

            <p class="text-gray-700 mb-1">
                <strong>Driver:</strong>
                <span
                    id="driver-name"
                    >{{ $activeOrder->mitra->name ?? '-' }}</span
                >
            </p>

            <p class="text-gray-700 mb-2">
                Status:
                <span id="order-status" class="font-semibold">
                    {{ $activeOrder->status }}
                </span>
            </p>

            <div class="flex items-center gap-3">
                <span
                    class="inline-block bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-semibold"
                >
                    Sedang Dalam Perjalanan
                </span>

                <span class="text-sm text-gray-600">
                    💰 Tarif: Rp {{ number_format($activeOrder->price) }}
                </span>
            </div>
        </div>
    </div>
    @endif @endif

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
            left: 110%;
            animation: drive 6s linear infinite;
        }
    </style>

    {{-- CHAT DRIVER --}}
    <div class="mt-6 bg-white border rounded-xl p-4 shadow">
        <h4 class="font-semibold text-gray-700 mb-3">💬 Chat dengan Driver</h4>

        <div class="h-56 overflow-y-auto mb-3 space-y-2 bg-gray-50 p-3 rounded">
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

    {{-- MENU UTAMA --}}
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Antar Jemput -->
        <div
            class="group bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-2xl p-6 shadow-sm hover:shadow-lg transition"
        >
            <div
                class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl text-blue-600 mb-4"
            >
                🚕
            </div>
            <h3 class="text-xl font-semibold mb-2">Antar Jemput</h3>
            <p class="text-sm text-gray-500 mb-6">
                Perjalanan cepat & aman ke kampus atau tujuan lain.
            </p>
            <a
                href="{{ route('customer.order.create', ['service_type' => 'ride']) }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-semibold"
            >
                Pesan Sekarang →
            </a>
        </div>

        <!-- Jasa Titip -->
        <div
            class="group bg-gradient-to-br from-green-50 to-white border border-green-100 rounded-2xl p-6 shadow-sm hover:shadow-lg transition"
        >
            <div
                class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl text-green-600 mb-4"
            >
                🛒
            </div>
            <h3 class="text-xl font-semibold mb-2">Jasa Titip</h3>
            <p class="text-sm text-gray-500 mb-6">
                Titip beli makanan, minuman, atau kebutuhan harian.
            </p>
            <a
                href="{{ route('customer.order.create', ['service_type' => 'jastip']) }}"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-full font-semibold"
            >
                Pesan Sekarang →
            </a>
        </div>

        <!-- Riwayat -->
        <div
            class="group bg-gradient-to-br from-teal-50 to-white border border-teal-100 rounded-2xl p-6 shadow-sm hover:shadow-lg transition"
        >
            <div
                class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-3xl text-teal-600 mb-4"
            >
                📄
            </div>
            <h3 class="text-xl font-semibold mb-2">Riwayat Pesanan</h3>
            <p class="text-sm text-gray-500 mb-6">
                Lihat semua pesanan yang pernah kamu buat.
            </p>
            <a
                href="{{ route('customer.orders.history') }}"
                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-full font-semibold"
            >
                Lihat Riwayat →
            </a>
        </div>
    </div>
</div>

<script>
    const orderId = "{{ $activeOrder->id ?? '' }}";

    if (orderId) {
        setInterval(() => {
            fetch(`/order/${orderId}/status`)
                .then((res) => res.json())
                .then((data) => {
                    const statusText = document.getElementById("order-status");
                    const driverName = document.getElementById("driver-name");

                    if (statusText) {
                        statusText.innerText = data.status;
                    }

                    if (driverName && data.driver) {
                        driverName.innerText = data.driver;
                    }

                    if (data.status === "completed") {
                        location.reload();
                    }
                });
        }, 4000);
    }
</script>

@endsection
