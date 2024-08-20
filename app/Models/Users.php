<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Users extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'avatar',
        'company_name',
        'flag',
        'country',
        'city',
        'state',
        'address',
        'zip_code',
        'is_active',
        'is_admin',
        'joined_date'
    ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->joined_date = Carbon::now('Asia/Dhaka');
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'joined_date' => 'datetime'
    ];

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function getWishlistProducts()
    {
        return $this->wishlist->map(function ($item) {
            return $item->product;
        });
    }
}