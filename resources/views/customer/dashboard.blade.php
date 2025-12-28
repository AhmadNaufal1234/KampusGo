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

    @if($activeOrder) @php $driverName = $activeOrder->mitra->name ?? 'Driver';
    @endphp

    {{-- ================= MENUNGGU DRIVER ================= --}}
    @if($activeOrder->status === 'pending')
    <div class="text-center mb-12">
        {{-- RADAR --}}
        <div class="relative w-40 h-40 mx-auto mb-6">
            <div
                class="absolute inset-0 rounded-full bg-blue-400 opacity-20 radar"
            ></div>
            <div
                class="absolute inset-6 rounded-full bg-blue-300 opacity-30 radar-delay"
            ></div>
            <div
                class="absolute inset-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl"
            >
                📍
            </div>
        </div>

        <h3 class="text-xl font-semibold text-gray-800 mb-2">
            Mencari Driver Terdekat...
        </h3>
        <p class="text-gray-500">Sistem sedang memindai lokasi driver 📡</p>
    </div>
    @endif

    {{-- ================= DRIVER AKTIF ================= --}}
    @if(in_array($activeOrder->status, ['accepted','arrived','on_the_way']))
    <div class="mb-10">
        <h3 class="text-xl font-semibold text-center mb-3">
            @if($activeOrder->status === 'accepted') Driver Menuju Lokasi 🚗
            @elseif($activeOrder->status === 'arrived') Driver Sudah Sampai 📍
            @elseif($activeOrder->status === 'on_the_way') Sedang Dalam
            Perjalanan 🚀 @endif
        </h3>

        {{-- JALAN --}}
        <div class="relative h-20 overflow-hidden bg-blue-100 rounded-xl mb-4">
            <div
                class="absolute top-1/2 -translate-y-1/2 animate-drive
            {{ $activeOrder->status === 'on_the_way' ? 'fast' : '' }}"
            >
                🛵
            </div>
        </div>

        <div
            class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-center"
        >
            <p><strong>Driver:</strong> {{ $driverName }}</p>
            <p class="mt-1">
                {{ $activeOrder->pickup_address }} →
                {{ $activeOrder->destination_address }}
            </p>
            <p class="mt-2 text-green-600 font-semibold">
                💰 Rp {{ number_format($activeOrder->price) }}
            </p>
        </div>
    </div>
    @endif

    {{-- ================= COMPLETED ================= --}}
    @if($activeOrder->status === 'completed')
    <div class="bg-gray-50 border rounded-xl p-6 text-center mb-10">
        <h3 class="text-xl font-semibold text-gray-700">✅ Pesanan Selesai</h3>
        <p class="text-gray-500 mt-1">
            Terima kasih sudah menggunakan layanan kami 🙏
        </p>
    </div>
    @endif @endif

    <style>
        /* RADAR */
        @keyframes radar {
            0% {
                transform: scale(0.3);
                opacity: 0.6;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .radar {
            animation: radar 2s infinite;
        }

        .radar-delay {
            animation: radar 2s infinite;
            animation-delay: 1s;
        }

        /* DRIVER JALAN */
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
            font-size: 2rem;
            animation: drive 6s linear infinite;
        }

        /* CEPAT SAAT ON THE WAY */
        .fast {
            animation-duration: 3s;
        }
    </style>

    @if($activeOrder && in_array($activeOrder->status, ['accepted',
    'on_the_way']))
    {{-- CHAT DRIVER --}}
    <div class="mt-6 bg-white border rounded-xl p-4 shadow">
        <h4 class="font-semibold text-gray-700 mb-3">💬 Chat dengan Driver</h4>

        <div class="h-56 overflow-y-auto mb-3 space-y-2 bg-gray-50 p-3 rounded">
            @forelse($activeOrder->messages ?? [] as $msg)
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
            @empty
            <p class="text-center text-gray-400 text-sm">Belum ada pesan</p>
            @endforelse
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
    @endif

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

@if($activeOrder)
<script>
    const orderId = "{{ $activeOrder->id }}";

    setInterval(() => {
        fetch(`{{ url('/order') }}/${orderId}/status`)
            .then((res) => res.json())
            .then((data) => {
                const statusText = document.getElementById("order-status");
                const driverName = document.getElementById("driver-name");

                if (statusText) statusText.innerText = data.status;
                if (driverName && data.driver)
                    driverName.innerText = data.driver;

                if (data.status === "completed") location.reload();
            });
    }, 4000);
</script>
@endif @endsection
