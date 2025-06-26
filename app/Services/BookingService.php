<?php

namespace App\Services;
use App\Models\Booking; 
use Auth;
use Carbon\Carbon;

class BookingService{
    protected $model;
    public function __construct(){
        $this->model = new Booking(); 
    }

    public function create($car){
         
        $this->model->create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'status' => 'booked'
        ]);

    }
    
    public function storeHourlyBooking(array $data): Booking
    {
        $endTime = Carbon::parse($data['start_time'])->addHours($data['duration_hours'])->format('H:i');

        $booking = Booking::create([
            'user_id'        => Auth::id(),
            'car_id'         => $data['car_id'],
            'booking_date'   => $data['booking_date'],
            'start_time'     => $data['start_time'],
            'end_time'       => $endTime,
            'duration_hours' => $data['duration_hours'],
            'is_hourly'      => true,
            'status'         => 0
        ]);

        // Update car status (car() is a relation on Booking)
        $booking->car()->update(['status' => 0]);

        return $booking;
    }
}
 