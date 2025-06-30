<?php

namespace App\Services;
use App\Models\Booking; 
use Auth;
use Carbon\Carbon;
use App\Models\Carlist;
use Exception;
use Request;

class BookingService{
    protected $model;
    public function __construct(){
        $this->model = new Booking(); 
    }

    public function create($car){
         
        $this->model->create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'status' => 'booked',
            'is_hourly' => false // Explicitly mark as daily booking

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
        ]);

        // Update car status 
        // $booking->car()->update(['status' => 0]);
        $booking->car()->update(['status' => 1]);


        return $booking;
    }
    public function AvailableSlots(Carlist $car, $date)
    {
        try {
            $slots = $car->getAvailableSlots($date);
            
            return [
                'success' => true,
                'car' => $car->name,
                'date' => $date,
                'available_slots' => $slots
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
}
 