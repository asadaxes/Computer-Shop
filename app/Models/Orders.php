<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Orders extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id ',
        'amount',
        'quantity',
        'delivery_method',
        'shipping_address',
        'deliver_status',
        'status',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    protected $casts = [
        'shipping_address' => 'array',
        'issued_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}