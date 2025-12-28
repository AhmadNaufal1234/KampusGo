@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Buat Pesanan 🚀
        </h2>
        <p class="text-gray-500 mt-1">
            Lengkapi data di bawah untuk melanjutkan pemesanan
        </p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('customer.order.store') }}"
          class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
        @csrf

        <!-- Service Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jenis Layanan
            </label>
            <select name="service_type"
                    class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200">
                <option value="ride">🚕 Antar Jemput</option>
                <option value="jastip">🛒 Jasa Titip</option>
            </select>
        </div>

        <!-- Pickup -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Titik Jemput
            </label>
            <input type="text" name="pickup_address"
                   placeholder="Contoh: Gerbang Kampus / Kos"
                   class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <!-- Destination -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tujuan
            </label>
            <input type="text" name="destination_address"
                   placeholder="Contoh: Perpustakaan / Warung Makan"
                   class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <!-- Item Description (Jastip) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Detail Barang (Khusus Jastip)
            </label>
            <textarea name="item_description" rows="3"
                      placeholder="Contoh: Ayam geprek level 3, es teh"
                      class="w-full p-2.5 border rounded-lg focus:ring focus:ring-green-200"></textarea>
        </div>

        <!-- Distance -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jarak Perjalanan (KM)
            </label>
            <input type="number" name="distance_km" step="0.1"
                   placeholder="Contoh: 2.5"
                   class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <!-- Payment -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Metode Pembayaran
            </label>
            <select name="payment_method"
                    class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200">
                <option value="cash">💵 Cash</option>
                <option value="ewallet">📱 E-Wallet</option>
            </select>
        </div>

        <!-- Button -->
        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700
                           text-white font-semibold py-3 rounded-lg transition">
                Pesan Sekarang
            </button>
        </div>
    </form>

</div>
@endsection
