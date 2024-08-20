<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accessories_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accessories_categories');
    }
};