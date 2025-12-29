@extends('layouts.app') @section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Buat Pesanan Anda</h2>
        <p class="text-gray-500 mt-1">
            Lengkapi data di bawah untuk melanjutkan pemesanan
        </p>
    </div>

    <!-- Form -->
    <form
        id="orderForm"
        method="POST"
        action="{{ route('customer.order.store') }}"
        class="bg-white rounded-xl shadow-sm border p-6 space-y-4"
    >
        @csrf

        <!-- Service Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jenis Layanan
            </label>
            <select
                name="service_type"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200"
            >
                <option value="ride">🛵 Antar Jemput</option>
                <option value="jastip">🛒 Jasa Titip</option>
            </select>
        </div>

        <!-- Pickup -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Titik Jemput
            </label>
            <input
                type="text"
                name="pickup_address"
                placeholder="Contoh: Gerbang Kampus / Kos"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200"
            />
        </div>

        <!-- Destination -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tujuan
            </label>
            <input
                type="text"
                name="destination_address"
                placeholder="Contoh: Perpustakaan / Warung Makan"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200"
            />
        </div>

        <!-- Item Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Detail Barang (Khusus Jastip)
            </label>
            <textarea
                name="item_description"
                rows="3"
                placeholder="Contoh: Ayam geprek level 3, es teh"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-green-200"
            ></textarea>
        </div>

        <!-- Distance -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jarak Perjalanan (KM)
            </label>
            <input
                type="number"
                name="distance_km"
                step="0.1"
                placeholder="Contoh: 2.5"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200"
            />
        </div>

        <!-- Payment -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Metode Pembayaran
            </label>
            <select
                name="payment_method"
                id="payment_method"
                class="w-full p-2.5 border rounded-lg focus:ring focus:ring-blue-200"
            >
                <option value="cash">💵 Cash</option>
                <option value="ewallet">📱 E-Wallet</option>
            </select>
        </div>

        <!-- E-WALLET SECTION -->
        <div
            id="ewallet-section"
            class="hidden bg-blue-50 border border-blue-200 p-4 rounded-lg"
        >
            <p class="text-sm text-gray-700 mb-2">
                💳 Saldo E-Wallet Anda:
                <strong
                    >Rp {{ number_format(auth()->user()->saldo ?? 0) }}</strong
                >
            </p>
            <p class="text-xs text-gray-500 mb-4">
                Saldo akan ditahan oleh sistem sampai pesanan selesai.
            </p>

            <button
                type="button"
                onclick="submitWithEwallet()"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold"
            >
                Bayar Sekarang
            </button>
        </div>

        <!-- CASH BUTTON -->
        <div id="cash-section" class="pt-4">
            <button
                type="button"
                id="submitOrderBtn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Pesan Sekarang
            </button>
        </div>
    </form>
</div>

<!-- SCRIPT -->
<script>
    const paymentMethod = document.getElementById("payment_method");
    const ewalletSection = document.getElementById("ewallet-section");
    const cashSection = document.getElementById("cash-section");
    const form = document.getElementById("orderForm");

    paymentMethod.addEventListener("change", function () {
        if (this.value === "ewallet") {
            ewalletSection.classList.remove("hidden");
            cashSection.classList.add("hidden");
        } else {
            ewalletSection.classList.add("hidden");
            cashSection.classList.remove("hidden");
        }
    });

    function submitWithEwallet() {
        if (confirm("Saldo akan ditahan oleh sistem. Lanjutkan pembayaran?")) {
            form.submit();
        }
    }
</script>
<script>
document.getElementById('submitOrderBtn').addEventListener('click', function () {
    Swal.fire({
        title: 'Konfirmasi Pesanan',
        text: 'Apakah data pesanan sudah benar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Pesan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            this.closest('form').submit();
        }
    });
});
</script>
<script>
function submitWithEwallet() {
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: 'Saldo e-wallet akan dipotong sesuai total pesanan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Bayar Sekarang',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('orderForm').submit();
        }
    });
}
</script>

@endsection
