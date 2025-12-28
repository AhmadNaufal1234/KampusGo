<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request, Order $order)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        OrderMessage::create([
            'order_id' => $order->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back();
    }
}