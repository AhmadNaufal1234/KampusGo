{{-- resources/views/mitra/topup.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        💰 Top Up Saldo
    </h2>

    <div class="bg-white rounded-xl p-6 shadow border">
        <p class="text-gray-600 mb-4">
            Saldo Saat Ini:
            <span class="font-bold text-green-600">
                Rp {{ number_format(auth()->user()->saldo) }}
            </span>
        </p>

        <form method="POST" action="{{ route('mitra.topup.store') }}">
            @csrf

            <label class="block text-sm font-semibold mb-2">
                Nominal Top Up
            </label>

            <input
                type="number"
                name="amount"
                min="10000"
                step="1000"
                required
                class="w-full border rounded-lg px-4 py-2 mb-4"
                placeholder="Minimal Rp 10.000"
            />

            <button
                class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold"
            >
                💳 Top Up Sekarang
            </button>
        </form>
    </div>

</div>
@endsection
