<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = 'refund';
    protected $fillable = ['booking_id', 'account_name', 'account_number', 'bank_name', 'refund_amount', 'status'];

    // Quan hệ với Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
