<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Carlist;
use App\Http\Requests\BookingCarRequest;
use App\Http\Requests\Booking\HourlyBookingRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;
use App\Services\CarListServices;



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
        // dd($booking->car);
        $carlistService = new CarListServices();
        try {
            // Authorization - ensure user can only cancel their own bookings
            if ($booking->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Only allow cancellation if booking is still active
            if ($booking->status !== 'booked') {
                return back()->with('error', 'This booking cannot be cancelled.');
            }
            // dd('here');
            // Update booking status

            $carlistService->updateCarListingUser($booking->car_id, $booking->car);
            return back()->with('success', 'Booking cancelled successfully!');
        } catch (Exception $e) {

            return back()->with('error', 'Failed to cancel booking. Please try again.');

        }
    }
    public function storeHourly(HourlyBookingRequest $request)
    {
        try {
            $booking = $this->bookingService->storeHourlyBooking($request->validated());

            // Redirect with success message (for web)
            if ($request->wantsJson()) {
                return response()->json([
                    'redirect' => route('user.dashboard'),
                    'message' => 'Hourly booking created successfully!'
                ], 201);
            }

            return redirect()->route('user.dashboard')
                ->with('success', 'Hourly booking created successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to create booking: ' . $e->getMessage()
                ], 400);
            }

            return back()->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }
}