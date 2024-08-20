<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupons extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_until',
        'usage_limit',
        'usage_count',
        'created_at'
    ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($code) {
            $code->created_at = Carbon::now('Asia/Dhaka');
        });
    }
}