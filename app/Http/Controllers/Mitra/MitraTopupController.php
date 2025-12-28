<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MitraTopupController extends Controller
{
    public function index()
    {
        return view('mitra.topup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $user = auth()->user();

        $user->saldo += $request->amount;
        $user->save();

        return redirect()
            ->route('mitra.dashboard')
            ->with('success', 'Saldo berhasil ditambahkan');
    }
}