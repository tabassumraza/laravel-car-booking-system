<?php

namespace App\Http\Controllers;

use App\Models\Carlist;
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
    public function index()
{
    $cars = $this->CarListService->getAllCarsWithUsers();
    return view('admin.car.index', compact('cars')); // Adjust view name as needed
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
        $this->CarListService->updateCarListing($id,$request->validated());
        return redirect()->back()->with('success', 'EDITING COMPLETE');
    }
//     public function index(CarListServices $carService)
// {
//     $cars = $carService->getAllCarsWithUsers();
//     return view('your.view', compact('cars'));
// }
// In CarListController.php

}
