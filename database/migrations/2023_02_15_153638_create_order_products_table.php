<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderId')
                ->constrained('orders');
            $table->unsignedBigInteger('productId');
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('price');
            $table->string('title');
            $table->unsignedInteger('discount');
            $table->string('vat');
            $table->string('barcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
