<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    protected $attributes = [
        'status' => 'booked',
    ];

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
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if booking is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'booked';
    }
}