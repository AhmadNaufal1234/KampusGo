<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        $mitras    = User::where('role', 'mitra')->get();

        $totalPotongan = Order::sum('admin_fee'); // 2%
        $totalTransaksi = Order::count();

        return view('admin.dashboard', compact(
            'customers',
            'mitras',
            'totalPotongan',
            'totalTransaksi'
        ));
    }
}