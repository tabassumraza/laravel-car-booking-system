<?php

namespace App\Http\Controllers;

use App\Models\carlist;
use Illuminate\Http\Request;

class CarListController extends Controller
{
     public function addcarlist(Request $request){
    $cl = new carlist();
    $cl->name = $request->input('name');
    $cl-> description= $request->input('description');
    $cl-> picture= $request->input('specification');

    $cl->save();
    // return redirect("/");
    // return "inserted";
}}