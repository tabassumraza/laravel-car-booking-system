<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Scopes\StatusScope;


class Carlist extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $fillable = ['name','carnum','description','status'];
    // protected $attributes = ['status' => 'available' ];
      protected $attributes = ['status' => 1]; // Default value

    protected function status(): Attribute {
        return Attribute::make(
            get: fn ($value) => $value ? 'available' : 'booked',
            set: fn ($value) => $value === 'available' ? 1 : 0
        );
    }

     public function booking()
    {
        return $this->hasMany(Booking::class,'car_id');
    }
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Booking::class,
            'car_id',  // Foreign key on bookings table
            'id',      // Foreign key on users table
            'id',      // Local key on carlists table
            'user_id'  // Local key on bookings table
        );
    }
    // protected static function booted(){
    //     static::addGlobalScope(new StatusScope());

    // }

}
