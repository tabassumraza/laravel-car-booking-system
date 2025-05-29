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
        return view('admin.car.add'); // Assuming you have a view at resources/views/cars/create.blade.php
    }
    
    // Store a new car listing
   
      public function store(CarListRequest $request) // Using Form Request
    {
        $validated = $request->validated(); // Get all validated data
        
        Carlist::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'carnum' => $validated['carnum'] ?? null,
            // 'car_number' => $validated['car_number'] ?? null
        ]);

        return redirect()->back()->with('success', 'Car listing added successfully!');
    }
      public function update(CarListRequest $request, $id)
    {
        $car = CarList::findOrFail($id);
        $car->book = $request->input('name');
        $car->description = $request->input('description');
        $car->carnum = $request->input('carnum');
        $car->save();
    
        return redirect()->back()->with('success', 'EDITING COMPLETE');
    }

}
