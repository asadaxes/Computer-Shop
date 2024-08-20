<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->json('products');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->enum('status', ['Upcoming', 'Active', 'Expired'])->default('Upcoming');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};