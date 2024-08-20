<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            FlashSaleSeeder::class,
            LayoutSeeder::class,
            SettingsSeeder::class
        ]);
    }
}