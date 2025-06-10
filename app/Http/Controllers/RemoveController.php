<?php

namespace App\Http\Controllers;
use App\Models\Carlist;
use App\Models\User;
use Illuminate\Http\Request;

class RemoveController extends Controller
{
    public function deleteCar(Request $request)
    {
        Carlist::destroy($request->id); 
        session()->flash('success', 'Car removed successfully!');

        return redirect()->back();
    }
   
public function destroy(User $user)
{
    // Get all cars that might need status updates
    $carsToUpdate = Carlist::whereHas('booking', function($query) use ($user) {
        $query->where('user_id', $user->id);
    })->get();
    
    // Delete the user (this will delete their bookings via cascade)
    $user->delete();
    
    // Update status for any cars that lost their last booking
    foreach ($carsToUpdate as $car) {
        if (!$car->booking()->exists()) {
            $car->update(['status' => 'available']);
        }
    }
    
    return redirect()->back()->with('success', 'User deleted successfully');
}
}
