<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestDeals extends Model
{
    protected $fillable = [
        'product_id'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}