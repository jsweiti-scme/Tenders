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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('mobile_number');
            $table->string('phone_number');
            $table->string('address');
            $table->string('license_worker_certification');
            $table->string('discount_certification_issuer');
            $table->date('discount_certification_issuer_expired_date')->nullable();
            $table->string('license_worker_number');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
