<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'status',
        'booking_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    
     protected $casts = [
        'booking_date' => 'datetime',
        // 'status' => 'boolean',

    ];

    /**
     * Default status value when creating new booking.
     * 
     * @var string
     */
    protected $attributes = [
        'status' => 'booked',
        // 'status' => 1, // default: booked

    ];

    //accessor and mutator 
  

    // public function getStatus($value)
    // {
    //     return $value ? 'booked' : 'available';
    // }

    // public function setStatus($value)
    // {
    //     if (strtolower($value) === 'booked' || $value === true || $value == 1) {
    //         $this->attributes['status'] = 1;
    //     } else {
    //         $this->attributes['status'] = 0;
    //     }
    // }

//  protected function status(): Attribute
//     {
//         // accessor(getters) and mutator(setters) to change value in DB and view 
//         return Attribute::make(
//             get: fn($value) => $value ? 'booked' : 'available',
//             set: fn($value) => $value == 'available' ? 0 : 1
//         );
//     }

    /**
     * Get the user that made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car that was booked.
     */
    public function car()
    {
        return $this->belongsTo(Carlist::class);
    }

    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'booked');
    }

    /**
     * Scope a query to only include completed bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
   
    /**
     * Check if booking is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'booked';
    }
    // app/Models/Booking.php
protected static function booted()
{
    static::deleted(function ($booking) {
        // When a booking is deleted, check if car has any other bookings
        $car = $booking->car;
        if ($car && !$car->bookings()->exists()) {
            $car->update(['status' => 'available']);
        }
    });
}
}