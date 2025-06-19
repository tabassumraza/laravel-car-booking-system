<?php

namespace App\Services;
use App\Models\Carlist; 
use Illuminate\Support\Collection;
use App\Models\Booking; 
use App\Services\BookingService;


class CarListServices{

    protected $model;
    protected $bookingService;
    public function __construct()
    {
        $this->model = new Carlist(); 
        $this->bookingService = new BookingService();
        // $this->bookingService = $bookingService;

    }
 
    public function storeCar($car)
{
    $createdCar = $this->model->create([
        'name' => $car['name'],
        'description' => $car['description'],
        'carnum' => $car['carnum'] ?? null,
        'status' => $car['status'],
        'user_id' => auth()->id() // You might want to add this too for consistency
    ]);
    
    // Create booking record if status is booked
    // if ($car['status'] == 'booked') {
    //     Booking::create([
    //         'car_id' => $createdCar->id,
    //         'user_id' => auth()->id(),
    //         'status' => 'booked',
    //         'admin_booked' => true,
    //     ]);
    // }
    // from bookingservice
    if ($car['status'] == 'booked') {
        $this->bookingService->create($createdCar);
    }
       
    return $createdCar;
} 
     
    public function updateCarListing($id, array $carData)
{
    $car = $this->model->findOrFail($id);
    
    // Handle status change from booked to available
    if ($carData['status'] == 'available' && $car->status == 'booked') {
        // Delete or cancel the booking
        Booking::where('car_id', $car->id)
               ->where('status', 0)
               ->forceDelete(); 
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
public function updateCarListingUser($id, $carData)
    {
        // dd('here');
        // dd($carData->status);
        $car = $this->model->findOrFail($id);

        // Handle status change from booked to available
        if (($carData->status == 'booked' || $carData['status'] == 'available') && $car->status == 'booked') {
            // dd('ehre');
            // Delete or cancel the booking
            Booking::where('car_id', $car->id)
                ->where('status', 0)
                ->delete();
        }

        $car->update([
            // 'id' => $carData->id,
            'name' => $carData->name,
            'user_id' => auth()->id(),
            'description' => $carData->description,
            'carnum' => $carData->carnum ?? null,
            'status' => "available"
        ]);

        return $car;
    }

  public function getAllCarsWithUsers(): Collection   
{
    return $this->model->with('users')->latest()->get();
}
}