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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            $table->string('orderCode');
            $table->foreignId('status')->constrained('statuses');
            $table->string('token');
            $table->string('url');
            $table->string('resultStatus')->comment('The status which we received from destination webhook');
            $table->timestamps();

            $table->comment('This table will log every request which is sent to particular webhook with its all details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_logs');
    }
};
