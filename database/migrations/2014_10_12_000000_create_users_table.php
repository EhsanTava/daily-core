<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('familyName');
            $table->unsignedBigInteger('nationalCode')->unique();
            $table->unsignedInteger('personalCode')->unique();
            $table->unsignedInteger('storeId');
            $table->unsignedBigInteger('mobile');
            $table->unsignedTinyInteger('role'); // TODO : make in model
            $table->string('status')->default(User::STATUS_ACTIVE); // TODO : make it in model
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
