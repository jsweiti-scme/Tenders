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
        Schema::table('tender_items', function (Blueprint $table) {
            $table->enum('award_status', ['pending', 'awarded', 'cancelled'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('tender_items', function (Blueprint $table) {
            $table->dropColumn('award_status');
        });
    }
};
