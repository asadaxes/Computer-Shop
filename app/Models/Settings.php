<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'favicon',
        'logo_site',
        'logo_admin',
        'title_site',
        'title_admin',
        'footer_copyright',
        'footer_description',
        'contact_address',
        'contact_phone',
        'contact_email',
        'social_ids',
        'ga_id',
        'meta_author',
        'meta_description',
        'meta_keywords',
        'delivery_charge_inside',
        'delivery_charge_outside',
        'tax'
    ];

    public $timestamps = false;
}