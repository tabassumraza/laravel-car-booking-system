<?php

use App\Models\Carlist;
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
     Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('car_id')->constrained('carlists')->onDelete('cascade');
    $table->string('status')->default('booked'); 

       
    // New columns for timing support
    $table->date('booking_date')->nullable(); // For daily bookings
    $table->date('return_date')->nullable(); // For daily bookings
    $table->time('start_time')->nullable(); // For hourly bookings
    $table->time('end_time')->nullable(); // For hourly bookings
    $table->boolean('is_hourly')->default(false); // Flag for booking type
    $table->integer('duration_hours')->nullable(); // Duration in hours
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
