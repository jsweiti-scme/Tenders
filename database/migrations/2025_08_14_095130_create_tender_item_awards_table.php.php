<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tender_item_awards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained()->onDelete('cascade');
            $table->foreignId('tender_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('winner_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('applicant_tender_item_id')->constrained()->onDelete('cascade'); // للربط مع السعر المقدم
            $table->decimal('awarded_price', 12, 3);
            $table->decimal('awarded_quantity', 12, 3);
            $table->text('notes')->nullable();
            $table->timestamp('awarded_at');
            $table->foreignId('awarded_by')->constrained('users');
            $table->timestamps();

            // فهرس مركب لمنع إرساء نفس العنصر أكثر من مرة
            $table->unique(['tender_id', 'tender_item_id'], 'unique_tender_item_award');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tender_item_awards');
    }
};
