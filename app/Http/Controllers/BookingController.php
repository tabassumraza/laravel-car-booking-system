<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Carlist;
use App\Http\Requests\BookingCarRequest;
use App\Http\Requests\Booking\HourlyBookingRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;
use App\Services\CarListServices;
use Illuminate\Http\Request;


use Exception;

class BookingController extends Controller
{

    protected $bookingService;
    public function __construct()
    {
        $this->bookingService = new BookingService();
        $this->carlistService = new CarListServices();

    }
    public function store(BookingCarRequest $request)
    {
        // validation is handled in bookingrequest file 
        // create booking is handled in bookingservice file

        $car = Carlist::findOrFail($request->car_id);

        if ($car->status !== 'available') {
            return back()->with('error', 'This car is not available for booking.');
        }

        // ERROR HANDLING and RENDERING MESSAGE FOR BOOKING CARS 
        try {
            $this->bookingService->create($car);
            $car->update(['status' => 'booked']);

            return redirect()->route('user.dashboard')
                ->with('success', 'Car booked successfully!');

        } catch (Exception $e) {
            return back()->with('error', 'Failed to create booking: ' . $e->getMessage());
        }

    }

   
    public function cancel(Booking $booking)
{
    $carlistService = new CarListServices();

    try {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if the booking is still active
        if ($booking->status !== 'booked') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Create carData from booking and car
        $carData = (object)[
            // "user_id"=>$booking->user_id,
            'status' => $booking->status,
            'booking_date' => $booking->booking_date,
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
            'name' => $booking->car->name,
            'description' => $booking->car->description,
            'carnum' => $booking->car->carnum,
        ];

        // Cancel booking
        $carlistService->updateCarListingUser($booking->car_id, $carData);

        return back()->with('success', 'Booking cancelled successfully!');
    } catch (Exception $e) {
        return back()->with('error', 'Failed to cancel booking. Please try again.');
    }
}

    public function storeHourly(HourlyBookingRequest $request)
    {
        try {
            $booking = $this->bookingService->storeHourlyBooking($request->validated());
        
        // Don't update car status for hourly bookings
        // The car remains available for other time slots
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Hourly booking created successfully!');
            
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
           
        }
        
    }

    public function availableSlots(Carlist $car, Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Date is required'], 400);
        }

        $result = $this->bookingService->AvailableSlots($car, $date);

        return response()->json($result);
    }
}