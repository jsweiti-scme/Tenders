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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->timestamps();
        });

        DB::table('cities')->insert([
            ['city' => 'القدس'],
            ['city' => 'بيت لحم'],
            ['city' => 'الخليل'],
            ['city' => 'رام الله'],
            ['city' => 'نابلس'],
            ['city' => 'سلفيت'],
            ['city' => 'قلقيلية'],
            ['city' => 'طولكرم'],
            ['city' => 'طوباس'],
            ['city' => 'جنين'],
            ['city' => 'أريحا والأغوار'],
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
