<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->json('header_sliders');
            $table->string('fp_img_1');
            $table->string('fp_text_1');
            $table->string('fp_img_2');
            $table->string('fp_text_2');
            $table->json('container');
            $table->string('parallax_banner');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layouts');
    }
};