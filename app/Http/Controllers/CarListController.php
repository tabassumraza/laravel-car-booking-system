<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarList\Request as CarListRequest;
use App\Services\CarListServices;


class CarListController extends Controller
{
    // servecies SECTION FILE DECLEARATION 
    protected $CarListService;
    public function __construct()
    {
        $this->CarListService = new CarListServices();
    }
    // render the username who booked the car in carlist table
    public function index()
    {
        $cars = $this->CarListService->getAllCarsWithUsers(); 
        return view('admin.car.index', compact('cars'));
    }
    // Show the form to create a new car listing
    public function create()
    {
        return view('admin.car.add');
    }

    // Store a new car listing
    public function store(CarListRequest $request)
    {
        $this->CarListService->storeCar($request->validated());
        return redirect()->back()->with('success', 'Car listing added successfully!');
    }

    public function update(CarListRequest $request, $id)
    {
        $this->CarListService->updateCarListing($id, $request->validated());
        return redirect()->back()->with('success', 'EDITING COMPLETE');
    }
}
