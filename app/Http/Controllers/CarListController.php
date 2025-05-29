<?php

namespace App\Http\Controllers;

use App\Models\Carlist; 
// use App\Http\Requests\CarList\Request;
use App\Http\Requests\CarList\Request as CarListRequest;


class CarListController extends Controller
{
    // Show the form to create a new car listing
    public function create()
    {
        return view('cars.create'); // Assuming you have a view at resources/views/cars/create.blade.php
    }
    
    // Store a new car listing
   
      public function store(CarListRequest $request) // Using Form Request
    {
        $validated = $request->validated(); // Get all validated data
        
        Carlist::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'picture' => $validated['picture'] ?? null,
            // 'car_number' => $validated['car_number'] ?? null
        ]);

        return redirect()->back()->with('success', 'Car listing added successfully!');
    }
}
