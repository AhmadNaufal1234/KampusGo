<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        $mitras    = User::where('role', 'mitra')->get();

        $transactions = Transaction::with('order')->latest()->get();

        $totalAdminSaldo = $transactions->sum('admin_fee');

        return view('admin.dashboard', compact(
            'customers',
            'mitras',
            'transactions',
            'totalAdminSaldo'
        ));
    }
}