<?php

namespace App\Services;
use App\Models\Booking; 
use Auth;

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
//     public function fetchByCarId($car_id){
//        return $this->model->where("car_id"->$car_id)->first();
         
// }


}
 