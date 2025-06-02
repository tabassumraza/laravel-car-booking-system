<?php

namespace App\Http\Controllers;

use App\Models\Carlist; 
use App\Http\Requests\CarList\Request as CarListRequest;


class CarListController extends Controller
{
    // Show the form to create a new car listing
    public function create()
    {
        return view('admin.car.add'); 
    }
    
    // Store a new car listing
   
      public function store(CarListRequest $request) 
    {
        $validated = $request->validated(); 
        
        Carlist::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'carnum' => $validated['carnum'] ?? null,
            'status' => 'available' 


        ]);

        return redirect()->back()->with('success', 'Car listing added successfully!');
    }
      public function update(CarListRequest $request, $id)
    {
        $car = CarList::findOrFail($id);
        $car->name = $request->input('name');
        $car->description = $request->input('description');
        $car->carnum = $request->input('carnum');
        $car->status = $request->input('status', 'available'); 

        $car->save();
    
        return redirect()->back()->with('success', 'EDITING COMPLETE');
    }

}
