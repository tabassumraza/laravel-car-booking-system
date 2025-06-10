<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Carlist;
use App\Http\Requests\BookingCarRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;
use Exception;

class BookingController extends Controller
{

    protected $bookingService;
    public function __construct()
    {
        $this->bookingService = new BookingService();
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
        //     if ($request->status === 'available') {
        //     $booking->delete(); // or soft delete
        //     return back()->with('success', 'Booking canceled and removed.');
        // }
    }
    public function cancel(Booking $booking)
    {
        try {
            // Authorization - ensure user can only cancel their own bookings
            if ($booking->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Only allow cancellation if booking is still active
            if ($booking->status !== 'booked') {
                return back()->with('error', 'This booking cannot be cancelled.');
            }

            // Update booking status
            $booking->update(['status' => 'cancelled']);

            // Update car status back to available
            $booking->car->update(['status' => 'available']);
            return back()->with('success', 'Booking cancelled successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to cancel booking. Please try again.');

        }
    }
}