<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'mitra_id',
        'service_type',
        'pickup_address',
        'destination_address',
        'item_description',
        'distance_km',
        'price',
        'payment_method',
        'status'
    ];
}