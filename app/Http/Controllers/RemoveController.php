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
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
