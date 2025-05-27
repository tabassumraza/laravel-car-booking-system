<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carlist extends Model
{
    use HasFactory;
    protected $primarykey = "id";
    protected $fillable = ['name','specification','description'];
}
