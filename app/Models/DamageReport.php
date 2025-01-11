<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;
    protected $table = 'damage_reports';

    protected $fillable = [
        'booking_detail_id',
        'user_id',
        'damage_description',
        'damage_cost',
        'payment_status',
    ];
    public function bookingDetail()
    {
        return $this->belongsTo(Booking_detail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
