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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('orderDate');
            $table->string('userCode');
            $table->string('userAddressCode');
            $table->foreignId('statusCode')
                ->constrained('statuses');
            $table->string('fullName');
            $table->string('firstName');
            $table->string('lastName');
            $table->decimal('latitude', 16, 14);
            $table->decimal('longitude', 16, 14);
            $table->string('deliverAddress');
            $table->text('comment')->nullable();
            $table->string('phone');
            $table->unsignedInteger('tax');
            $table->unsignedInteger('deliveryPrice');
            $table->unsignedInteger('packingPrice');
            $table->unsignedInteger('deliveryTime');
            $table->unsignedInteger('preparationTime');
            $table->unsignedInteger('taxCoeff');
            $table->string('vat');
            $table->string('discountType')->nullable();
            $table->unsignedInteger('discountValue');
            $table->timestamp('newOrderDate')->nullable();
            $table->string('orderPaymentTypeCode');
            $table->string('vendorCode');
            $table->string('saleInvoice')
                ->nullable()
                ->comment('The Invoice which will retrieved from Kian, Baran or ...');
            $table->foreignId('channel_id')
                ->constrained('channels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
