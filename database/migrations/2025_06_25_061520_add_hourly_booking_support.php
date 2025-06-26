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
    Schema::table('bookings', function (Blueprint $table) {
        $table->date('booking_date')->nullable()->after('status');
        $table->date('return_date')->nullable()->after('booking_date');
        $table->time('start_time')->nullable()->after('return_date');
        $table->time('end_time')->nullable()->after('start_time');
        $table->boolean('is_hourly')->default(false)->after('end_time');
        $table->integer('duration_hours')->nullable()->after('is_hourly');
    });
    
    Schema::table('carlists', function (Blueprint $table) {
        $table->time('available_from')->default('08:00:00')->after('status');
        $table->time('available_to')->default('20:00:00')->after('available_from');
        $table->integer('min_booking_hours')->default(1)->after('available_to');
        $table->integer('max_booking_hours')->default(12)->after('min_booking_hours');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
