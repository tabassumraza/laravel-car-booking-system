<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;


class Carlist extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
      protected $fillable = [
        'name',
        'carnum',
        'description',
        'status',
        'available_from',  // Add these new fields
        'available_to'     // for hourly availability
    ];
    // protected $attributes = ['status' => 'available' ];
      protected $attributes = [
    'status' => 1,// Default value
      'available_from' => '08:00:00',
        'available_to' => '20:00:00'
    ]; 
      protected $casts = [
        'available_from' => 'datetime',
        'available_to' => 'datetime'
    ];


    protected function status(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value ? 'available' : 'booked',
            set: fn ($value) => $value === 'available' ? 1 : 0
        );
    }

     public function booking()
    {
        return $this->hasMany(Booking::class,'car_id');
    }
//     public function userBookings()
// {
//     return $this->hasMany(Booking::class, 'car_id');
// }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Booking::class,
            'car_id',  // Foreign key on bookings table
            'id',      // Foreign key on users table
            'id',      // Local key on carlists table
            'user_id'  // Local key on bookings table
        );
    }
  
     public function isAvailableDuring($startTime, $endTime)
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);
        
        // Check if within car's operating hours
        $withinHours = $start >= Carbon::parse($this->available_from) && 
                      $end <= Carbon::parse($this->available_to);
        
        // For hourly bookings, we don't check the car's general status
        return $withinHours;
    }

    // public function getAvailableSlots($date)
    // {
    //     $bookedSlots = $this->bookings()
    //         ->whereDate('booking_date', $date)
    //         ->where('is_hourly', true)
    //         ->get(['start_time', 'end_time']);

    //     // Generate available time slots
    //     return $this->generateTimeSlots($bookedSlots);
    // }

    // protected function generateTimeSlots($bookedSlots)
    // {
    //     $slots = [];
    //     $start = Carbon::parse($this->available_from);
    //     $end = Carbon::parse($this->available_to);
        
    //     // Your slot generation logic here
    //     // This should return available time intervals
        
    //     return $slots;
    // }

}
