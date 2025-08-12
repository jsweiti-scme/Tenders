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
        Schema::create('answer_types', function (Blueprint $table) {
            $table->id();
            $table->string('answer_type');
            $table->string('answer_type_ar');
            $table->timestamps();
        });

        DB::table('answer_types')->insert([
            ['answer_type' => 'yes_no' , 'answer_type_ar'=>'صح\خطاً'],
            ['answer_type' => 'multiple_choice', 'answer_type_ar'=>'اختيار من متعدد'],
            ['answer_type' => 'text', 'answer_type_ar'=>'اجابة نصية'],
            ['answer_type' => 'file', 'answer_type_ar'=>'ملف'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_types');
    }
};
