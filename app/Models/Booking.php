<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Scopes\StatusScope;



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
        'return_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'booking_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    /**
     * Default status value when creating new booking.
     * 
     * @var string
     */

    // protected $attributes = [
    //     'status' => 'booked',
    // ];
    
protected $attributes = ['status' => 0]; // Default value

    protected function status(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value ? 'available' : 'booked',
            set: fn ($value) => $value === 'available' ? 1 : 0
        );
    }

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

    //    protected static function booted()
    // {
    //     static::addGlobalScope(new StatusScope());
    // }
    /**
     * Scope a query to only include active bookings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 0);
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
            $car->update([
                'status' => 1,
                 'user_id'=>null
    ]);
        }
    });
        static::addGlobalScope(new StatusScope());
}


}