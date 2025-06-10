<?php

namespace App\Services;
use App\Models\Carlist; 
use Illuminate\Support\Collection;
use App\Models\Booking; 


class CarListServices{

    protected $model;
    public function __construct()
    {
        $this->model = new Carlist(); 
    }
    public function storeCar($car)
    {
        $this->model->create([
            'name' => $car['name'],
            'description' => $car['description'],
            'carnum' => $car['carnum'] ?? null,
            'status' => 'available' 

        ]);
    }   
    
    public function updateCarListing($id, array $carData)
{
    $car = $this->model->findOrFail($id);
    
    // Handle status change from booked to available
    if ($carData['status'] == 'available' && $car->status == 'booked') {
        // Delete or cancel the booking
        Booking::where('car_id', $car->id)
               ->where('status', 'booked')
               ->delete(); // or ->update(['status' => 'cancelled']);
    }
    
    // Check if status is being changed to 'booked'
    $statusChangedToBooked = ($carData['status'] == 'booked') && ($car->status != 'booked');
    
    $car->update([
        'name' => $carData['name'],
        'user_id' => auth()->id(),
        'description' => $carData['description'],
        'carnum' => $carData['carnum'] ?? null,
        'status' => $carData['status']
    ]);
    
    // Create booking record if status changed to booked
    if ($statusChangedToBooked) {
        Booking::create([
            'car_id' => $car->id,
            'user_id' => auth()->id(),
            'status' => 'booked',
            'admin_booked' => true,
        ]);
    }
    
    return $car;
}


//    public function updateCarListing($id, array $carData)
// {
//     $car = $this->model->findOrFail($id);
  
    
//     // Check if status is being changed to 'booked'
//     $statusChangedToBooked = ($carData['status'] == 'booked') && ($car->status != 'booked');
    
//     $car->update([
//         'name' => $carData['name'],
//         'user_id' => auth()->id(), // Admin's ID
//         'description' => $carData['description'],
//         'carnum' => $carData['carnum'] ?? null,
//         'status' => $carData['status']
//     ]);
    
//     // Create booking record if status changed to booked
//     if ($statusChangedToBooked) {
//         Booking::create([
//             'car_id' => $car->id,
//             'user_id' => auth()->id(), // Admin's ID
//             'status' => 'booked',
//             'admin_booked' => true // Optional flag to distinguish admin bookings
//         ]);
//     }
    
//     return $car;
// }
  public function getAllCarsWithUsers(): Collection   
{
    return $this->model->with('users')->latest()->get();
}
}