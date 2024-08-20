<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Users;

class UsersSeeder extends Seeder
{
    public function run()
    {
        Users::create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'phone' => '+8801234567890',
            'password' => Hash::make('admin123'),
            'avatar' => 'users/default_avatar.png',
            'company_name' => 'MicroGigX',
            'flag' => 'default_flag',
            'country' => 'Turkiye',
            'city' => 'Istanbul',
            'address' => '25/05 road 123',
            'state' => 'Istanbul',
            'zip_code' => '12345',
            'is_active' => true,
            'is_admin' => true,
            'joined_date' => now(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
    }
}