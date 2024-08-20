<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoriesCategory extends Model
{
    protected $fillable = [
        'icon',
        'name'
    ];

    public $timestamps = false;
}