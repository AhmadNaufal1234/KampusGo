@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">

    <h2 class="text-2xl font-bold mb-6">📊 Dashboard Admin</h2>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">👥 Customer</p>
            <p class="text-2xl font-bold">{{ $customers->count() }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">🚕 Mitra</p>
            <p class="text-2xl font-bold">{{ $mitras->count() }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">💰 Saldo Admin (2%)</p>
            <p class="text-2xl font-bold text-green-600">
                Rp {{ number_format($totalAdminSaldo) }}
            </p>
        </div>
    </div>

    {{-- TRANSAKSI --}}
    <div class="bg-white rounded-xl shadow p-5 mb-8">
        <h3 class="text-lg font-semibold mb-4">💸 Sumber Potongan 2%</h3>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Order</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Admin 2%</th>
                    <th class="p-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-b">
                    <td class="p-2">#{{ $trx->order_id }}</td>
                    <td class="p-2 text-center">
                        Rp {{ number_format($trx->amount) }}
                    </td>
                    <td class="p-2 text-center text-green-600 font-semibold">
                        Rp {{ number_format($trx->admin_fee) }}
                    </td>
                    <td class="p-2 text-center">
                        {{ $trx->created_at->format('d M Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- USERS --}}
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="font-semibold mb-3">👤 Daftar Customer</h3>
            <ul class="space-y-2 text-sm">
                @foreach($customers as $c)
                    <li>{{ $c->name }} — {{ $c->email }}</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="font-semibold mb-3">🚕 Daftar Mitra</h3>
            <ul class="space-y-2 text-sm">
                @foreach($mitras as $m)
                    <li>{{ $m->name }} — {{ $m->email }}</li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
@endsection
