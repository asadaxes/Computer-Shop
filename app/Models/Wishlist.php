<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}