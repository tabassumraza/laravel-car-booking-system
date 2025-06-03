<?php

namespace App\Services;
use App\Models\Booking; 
use Auth;

class BookingService{

    //  $booking = Booking::create([
    //         'user_id' => Auth::id(),
    //         'car_id' => $car->id,
    //         'status' => 'booked'
    //     ]);

    protected $model;

    public function __construct(){
        $this->model = new Booking(); }

    public function create($car){
         
        $this->model->create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'status' => 'booked'
        ]);

}

}
 