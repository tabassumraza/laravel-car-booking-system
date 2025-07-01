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
        'available_from',
        'available_to'
    ];

    protected $attributes = [
        'status' => 1, // available
        'available_from' => '08:00:00',
        'available_to' => '20:00:00'
    ];

    // protected $casts = [
    //     'available_from' => 'datetime',
    //     'available_to' => 'datetime'
    // ];

    protected function status(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value ? 'available' : 'booked',
            set: fn ($value) => $value === 'available' ? 1 : 0
        );
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Booking::class,
            'car_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function isAvailableDuring($startTime, $endTime)
{
    $today = now()->toDateString(); // today's date
    $start = Carbon::parse("$today $startTime");
    $end = Carbon::parse("$today $endTime");

    $availableFrom = Carbon::parse("$today " . $this->available_from);
    $availableTo = Carbon::parse("$today " . $this->available_to);

    return $start >= $availableFrom && $end <= $availableTo;
}

    /**
     * Returns available hourly slots for a given date
     */
  
 public function getAvailableSlots($date)
{
    // Use the car's actual availability window instead of hardcoded values
    $start = Carbon::parse($this->available_from);
    $end = Carbon::parse($this->available_to);
    
    $allSlots = [];
    $current = $start->copy();
    
    while ($current->lt($end)) {
        $allSlots[] = [
            'start_time' => $current->format('H:i'),
            'end_time' => $current->copy()->addHour()->format('H:i'),
            'formatted' => $current->format('h:i A').' - '.$current->copy()->addHour()->format('h:i A')
        ];
        $current->addHour();
    }

    $bookedSlots = $this->booking()
        ->whereDate('booking_date', $date)
        ->where('is_hourly', true)
        ->get(['start_time', 'end_time'])
        ->toArray();

    $availableSlots = array_filter($allSlots, function ($slot) use ($bookedSlots) {
        foreach ($bookedSlots as $booked) {
            $slotStart = Carbon::parse($slot['start_time']);
            $slotEnd = Carbon::parse($slot['end_time']);
            $bookedStart = Carbon::parse($booked['start_time']);
            $bookedEnd = Carbon::parse($booked['end_time']);
            
            if ($slotStart->lt($bookedEnd) && $slotEnd->gt($bookedStart)) {
                return false;
            }
        }
        return true;
    });

    return array_values($availableSlots);
}

    protected function generateTimeSlots($bookedSlots)
    {
        $slots = [];
        $interval = 60; // minutes
        $buffer = 0;

        $startTime = Carbon::parse($this->available_from);
        $endTime = Carbon::parse($this->available_to);
        $current = $startTime->copy();

        $bookedRanges = $bookedSlots->map(function ($slot) {
            return [
                'start' => Carbon::parse($slot->start_time),
                'end' => Carbon::parse($slot->end_time)
            ];
        });

        while ($current->lt($endTime)) {
            $slotEnd = $current->copy()->addMinutes($interval);
            if ($slotEnd->gt($endTime)) break;

            $isAvailable = true;
            foreach ($bookedRanges as $booked) {
                if (
                    $current->lt($booked['end']) &&
                    $slotEnd->gt($booked['start'])
                ) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $slots[] = [
                    'start' => $current->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'duration' => ($interval / 60) . ' hours',
                    'formatted' => $current->format('h:i A') . ' - ' . $slotEnd->format('h:i A')
                ];
            }

            $current->addMinutes($interval + $buffer);
        }

        return $slots;
    }
}
