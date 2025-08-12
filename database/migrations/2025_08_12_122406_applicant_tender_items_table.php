<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('applicant_tender_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_tender_id');
            $table->unsignedBigInteger('tender_item_id');
            $table->decimal('price', 10, 2)->comment('سعر الوحدة من المتقدم');
            $table->timestamps();

            $table->foreign('applicant_tender_id')->references('id')->on('applicant_tenders')->onDelete('cascade');
            $table->foreign('tender_item_id')->references('id')->on('tender_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_items');
    }
};