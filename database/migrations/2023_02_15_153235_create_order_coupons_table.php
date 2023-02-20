<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderId')
                ->constrained('orders');
            $table->unsignedInteger('couponId');
            $table->string('descriptions')->nullable();
            $table->string('conditionCode');
            $table->string('rewardCode');
            $table->string('rewardParams'); // TODO : cast to array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_coupons');
    }
};
