<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payments extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'currency',
        'tran_id',
        'status',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            $payment->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    protected $casts = [
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