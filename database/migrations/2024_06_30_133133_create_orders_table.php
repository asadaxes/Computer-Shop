<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('amount');
            $table->integer('quantity');
            $table->enum('delivery_method', ['pay_with_ssl', 'cash_on_delivery']);
            $table->json('shipping_address');
            $table->enum('deliver_status', ['placed', 'preparing', 'shipping', 'delivered', 'cancelled'])->default('placed');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('issued_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};