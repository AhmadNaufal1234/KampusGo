@extends('layouts.app')

@foreach($orders as $order)
<div class="bg-white p-4 rounded shadow mb-3">
    <p>{{ $order->pickup_address }} → {{ $order->destination_address }}</p>
    <p>Harga: Rp {{ number_format($order->price) }}</p>

    <form method="POST" action="/mitra/order/{{ $order->id }}/accept">
        @csrf
        <button class="bg-green-600 text-white px-3 py-1 rounded">
            Terima
        </button>
    </form>
</div>
@endforeach

