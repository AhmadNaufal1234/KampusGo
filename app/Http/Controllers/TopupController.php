<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function create()
    {
        return view('topup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);

        auth()->user()->increment('saldo', $request->amount);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Top up berhasil 🎉');
    }
}