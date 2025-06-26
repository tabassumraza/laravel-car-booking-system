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
        Schema::create('carlists', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('description',500);
            $table->integer('carnum')->unique();
            $table->string('status')->default('available'); 

               // New columns for hourly booking support
    $table->time('available_from')->default('08:00:00');
    $table->time('available_to')->default('20:00:00');
    $table->integer('min_booking_hours')->default(1);
    $table->integer('max_booking_hours')->default(12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carlists');
    }
    
};
