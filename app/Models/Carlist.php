<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Carlist extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $fillable = ['name', 'carnum', 'description', 'status'];
    // protected $attributes = ['status' => 'available' ];
   
    // protected  function casts(){
    //     return [
    //         'status'=> 'boolean', 
    //     ];
    // }
    protected function status(): Attribute
    {
        // accessor(getters) and mutator(setters) to change value in DB and view 
        return Attribute::make(
            get: fn($value) => $value ? 'available' : 'booked',
            set: fn($value) => $value == 'available' ? 1 : 0
        );
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'car_id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Booking::class,
            'car_id',
            'id',
            'id',
            'user_id'
        );
    }

}
