<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $fillable = ['province', 'district', 'ward', 'street', 'pickup_time', 'return_time'];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
