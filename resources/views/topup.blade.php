@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-6">

    <h2 class="text-xl font-bold mb-4">💰 Top Up Saldo</h2>

    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <p class="text-sm text-gray-600 mb-2">
            Saldo Saat Ini:
            <strong>Rp {{ number_format(auth()->user()->saldo ?? 0) }}</strong>
        </p>

        <form method="POST" action="{{ route('topup.store') }}">
            @csrf

            <label class="block text-sm font-medium mb-1">
                Nominal Top Up
            </label>

            <input type="number" name="amount"
                   class="w-full border rounded-lg p-2 mb-4"
                   placeholder="Minimal 10.000">

            <button
                class="w-full bg-green-600 hover:bg-green-700
                       text-white py-3 rounded-lg font-semibold">
                💳 Bayar & Top Up
            </button>
        </form>
    </div>

</div>
@endsection
