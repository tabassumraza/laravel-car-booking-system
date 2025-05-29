<?php

namespace App\Http\Controllers;
use App\Models\Carlist;
use Illuminate\Http\Request;

class RemoveController extends Controller
{
        public function deleteCar(Request $request)
{
    Carlist::destroy($request->id); // This deletes the record by ID
    session()->flash('success', 'Car removed successfully!');
    
           return redirect()->back();        
}

}
