<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $fillable = [
        'header_sliders',
        'fp_img_1',
        'fp_text_1',
        'fp_img_2',
        'fp_text_2',
        'container',
        'parallax_banner'
    ];

    public $timestamps = false;

    protected $casts = [
        'header_sliders' => 'array',
        'container' => 'array'
    ];
}