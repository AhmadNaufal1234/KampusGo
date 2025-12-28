<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
public function index()
{
$activeOrder = Order::with(['messages', 'mitra'])
    ->where('customer_id', auth()->id())
    ->whereIn('status', ['pending', 'accepted', 'arrived', 'on_the_way'])
    ->latest()
    ->first();


return view('customer.dashboard', compact('activeOrder'));
}
}