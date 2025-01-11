<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['car_id', 'user_id', 'pickup_address_id', 'return_address_id', 'pickup_type', 'rental_days'];

    public function pickupAddress()
    {
        return $this->belongsTo(Address::class, 'pickup_address_id');
    }

    public function returnAddress()
    {
        return $this->belongsTo(Address::class, 'return_address_id');
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
