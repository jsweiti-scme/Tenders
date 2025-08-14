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
        Schema::table('tenders', function (Blueprint $table) {
            // إبقاء winner_id للتوافق مع النظام القديم لكن جعله nullable
            $table->enum('award_status', ['open', 'partially_awarded', 'fully_awarded', 'cancelled'])->default('open');
            $table->timestamp('award_completed_at')->nullable();
            $table->decimal('total_awarded_amount', 15, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn(['award_status', 'award_completed_at', 'total_awarded_amount']);
        });
    }
};
