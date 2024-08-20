<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class invoices extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    protected $casts = [
        'issued_at' => 'datetime'
    ];
}