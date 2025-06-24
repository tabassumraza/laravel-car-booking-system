<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Carlist;
use App\Models\Booking;

class UserController extends Controller
{
    /**
     * Display the user dashboard with available cars and user bookings
     *
     * @return \Illuminate\View\View
     */
    // In your controller where you load the dashboard
    public function dashboard()
    {
        // $availableCars = Carlist::where('status', 'available')->get();
        $availableCars = Carlist::where('status', true)->get();


        // get bookings 
        $userBookings = Booking::with('car')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', [
            'availableCars' => $availableCars,
            'userBookings' => $userBookings
        ]);
    }
}
