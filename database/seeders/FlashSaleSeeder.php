<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlashSale;
use Carbon\Carbon;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        FlashSale::create([
            'products' => json_encode([]),
            'from_date' => Carbon::now()->subDays(1),
            'to_date' => Carbon::now()->addDays(3),
            'status' => 'Active'
        ]);
    }
}