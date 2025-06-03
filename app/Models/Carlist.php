<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carlist extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $fillable = ['name','carnum','description','status'];
    protected $attributes = ['status' => 'available' ];

     public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
