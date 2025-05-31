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
        Schema::create('masyarakats', function (Blueprint $table) {
            $table->id();
            $table->string('NIK')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->text("address")->nullable();
            $table->string("phone")->nullable();
            $table->string('verification_token')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->dateTime('verification_token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masyarakats');
    }
};
