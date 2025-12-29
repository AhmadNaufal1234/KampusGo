<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'payment_status',
        'status'
    ];

    /**
     * CUSTOMER (PEMESAN)
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * MITRA / DRIVER
     */
    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    /**
     * CHAT MESSAGES
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\OrderMessage::class);
    }
}