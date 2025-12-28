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

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\OrderMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}