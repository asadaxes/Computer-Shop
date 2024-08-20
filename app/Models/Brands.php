<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = [
        'name',
        'logo',
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}