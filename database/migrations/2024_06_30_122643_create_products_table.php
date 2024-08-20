<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('sku');
            $table->json('featured')->nullable();
            $table->longText('description')->nullable();
            $table->json('specification')->nullable();
            $table->enum('condition', ['New', 'Used', 'Refurbished'])->nullable();
            $table->json('images');
            $table->integer('sale_price');
            $table->integer('regular_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->json('tags')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('publish_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};