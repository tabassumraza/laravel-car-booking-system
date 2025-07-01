<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Scopes\StatusScope;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'status',
        'booking_date',
        'return_date',
        'start_time',
        'end_time',
        'duration_hours',
        'is_hourly'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'return_date' => 'datetime',
         'start_time' => 'string',  // Changed from datetime
    'end_time' => 'string', 
        'is_hourly' => 'boolean'
    ];


   
      protected $attributes = [
        'status' => 0,
        'is_hourly' => false
    ]; // Default value

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? 'available' : 'booked',
            set: fn($value) => $value === 'available' ? 1 : 0
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Carlist::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeHourly($query)
    {
        return $query->where('is_hourly', true);
    }

    public function scopeDaily($query)
    {
        return $query->where('is_hourly', false);
    }

    public function isActive()
    {
        return $this->status === 'booked';
    }

    public function isCurrentlyActive()
    {
        if (!$this->is_hourly) return false;
        
        $now = now();
        $bookingDate = Carbon::parse($this->booking_date);
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        
        return $now->isSameDay($bookingDate) && 
               $now->between($start, $end);
    }

  protected static function booted()
{
    static::addGlobalScope(new StatusScope());

    static::created(function ($booking) {
        // Only update car status for daily bookings
        if (!$booking->is_hourly) {
            $booking->car->update([
                'status' => 0, // booked
                'user_id' => $booking->user_id
            ]);
        }
    });

    static::deleted(function ($booking) {
        // Only update status if it's a daily booking
        // Or if it's the last hourly booking
        if (!$booking->is_hourly || !$booking->car->bookings()->active()->exists()) {
            $booking->car->update([
                'status' => 1, // available
                'user_id' => null
            ]);
        }
    });
}

   public static function SlotAvailable($carId, $bookingDate, $startTime, $endTime, $ignoreId = null)
{
    $query = self::where('car_id', $carId)
        ->where('status', 0)
        ->whereDate('booking_date', $bookingDate)
        ->where(function($q) use ($startTime, $endTime) {
            $q->whereBetween('start_time', [$startTime, $endTime])
              ->orWhereBetween('end_time', [$startTime, $endTime])
              ->orWhere(function($q) use ($startTime, $endTime) {
                  $q->where('start_time', '<', $startTime)
                    ->where('end_time', '>', $endTime);
              });
        });
    
    if ($ignoreId) {
        $query->where('id', '!=', $ignoreId);
    }
    
    return $query->doesntExist();
}

  public static function createHourlyBooking(array $data)
{
    return DB::transaction(function () use ($data) {
        $car = Carlist::findOrFail($data['car_id']);
        
        $start = Carbon::parse($data['start_time']);
        $end = $start->copy()->addHours($data['duration_hours']);
        
        if (!$car->isAvailableDuring($start->format('H:i'), $end->format('H:i'))) {
            throw new \Exception('Car not available during requested hours');
        }
        
        if (!self::SlotAvailable($data['car_id'], $start->format('H:i'), $end->format('H:i'))) {
            throw new \Exception('Time slot already booked');
        }
        
        $booking = self::create([
            'user_id' => Auth::id(),
            'car_id' => $data['car_id'],
            'booking_date' => $data['booking_date'],
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'duration_hours' => $data['duration_hours'],
            'is_hourly' => true,
            'status' => 0
        ]);

        // Return the updated available slots
        return [
            'booking' => $booking,
            'available_slots' => $car->getAvailableSlots($data['booking_date'])
        ];
    });
}

   
}