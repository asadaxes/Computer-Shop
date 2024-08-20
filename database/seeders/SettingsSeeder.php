<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Settings::create([
            'favicon' => 'path/to/favicon.ico',
            'logo_site' => 'path/to/logo.png',
            'logo_admin' => 'path/to/admin-logo.png',
            'title_site' => 'Your Website Title',
            'title_admin' => 'Admin Dashboard',
            'footer_copyright' => '© 2024 Your Company',
            'footer_description' => 'Your company description for footer',
            'contact_address' => '123 Main St, City, Country',
            'contact_phone' => '+1234567890',
            'contact_email' => 'info@example.com',
            'social_ids' => json_encode(['facebook' => 'facebook-id', 'twitter' => 'twitter-id']),
            'ga_id' => 'UA-XXXXX-Y',
            'meta_author' => 'Your Name',
            'meta_description' => 'Meta description for SEO',
            'meta_keywords' => 'keyword1, keyword2, keyword3',
        ]);
    }
}