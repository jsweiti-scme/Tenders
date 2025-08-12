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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->smallInteger('status');
            $table->datetime('start_date');
            $table->datetime('end_date');

            $table->unsignedBigInteger('winner_id')->nullable();
            $table->unsignedBigInteger('created_by');

            $table->foreign('winner_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
