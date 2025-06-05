<?php

namespace App\Services;
use App\Models\Carlist; 

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
            $car->update([
                'name' => $carData['name'],
                'description' => $carData['description'],
                'carnum' => $carData['carnum'] ?? null,
                'status' => $carData['status']
            ]);
            return $car;
    }
    // In CarListServices.php
public function getAllCarsWithUsers()
{
    return $this->model->with('users')->latest()->get();
}
    //     public function getAllCarsWithUsers()
    // {
    //     return $this->model->with('currentUser')->latest()->get();
    // }
}