<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layout;

class LayoutSeeder extends Seeder
{
    public function run(): void
    {
        Layout::create([
            'header_sliders' => json_encode([]),
            'fp_img_1' => '',
            'fp_text_1' => '',
            'fp_img_2' => '',
            'fp_text_2' => '',
            'container' => json_encode([]),
            'parallax_banner' => ''
        ]);
    }
}