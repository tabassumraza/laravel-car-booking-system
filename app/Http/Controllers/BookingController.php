<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Carlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:carlists,id'
        ]);

        $car = Carlist::findOrFail($request->car_id);

        if ($car->status !== 'available') {
            return back()->with('error', 'This car is not available for booking.');
        }

        // Create the booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'status' => 'booked'
        ]);

        // Update car status
        $car->update(['status' => 'booked']);

        return redirect()->route('user.dashboard')->with('success', 'Car booked successfully!');
    }
}