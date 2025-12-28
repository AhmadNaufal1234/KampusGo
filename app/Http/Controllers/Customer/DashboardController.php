<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
public function index()
{
$activeOrder = Order::where('customer_id', auth()->id())
->whereIn('status', ['pending', 'accepted'])
->latest()
->first();

return view('customer.dashboard', compact('activeOrder'));
}
}