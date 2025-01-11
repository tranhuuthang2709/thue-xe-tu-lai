<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'car_id'];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
