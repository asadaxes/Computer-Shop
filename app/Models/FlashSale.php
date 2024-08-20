<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'products',
        'from_date',
        'to_date',
        'status'
    ];

    public $timestamps = false;

    protected $casts = [
        'products' => 'array',
        'from_date' => 'datetime',
        'to_date' => 'datetime'
    ];

    public function getProducts()
    {
        return Products::whereIn('id', $this->products)->get();
    }
}