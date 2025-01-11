<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_method',
        'total_amount',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function booking_detail()
    {
        return $this->hasMany(Booking_detail::class, 'order_id', 'id');
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
