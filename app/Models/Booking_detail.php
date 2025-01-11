<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_detail extends Model
{
    use HasFactory;
    protected $table = 'bookings_detail';
    protected $fillable = [
        'order_id',
        'car_id',
        'pickup_address_id',
        'return_address_id',
        'rental_price',
        'pickup_status',
        'return_status',
        'pickup_type',
        'rental_days'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'order_id', 'id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function pickupAddress()
    {
        return $this->belongsTo(Address::class, 'pickup_address_id', 'id');
    }

    public function returnAddress()
    {
        return $this->belongsTo(Address::class, 'return_address_id', 'id');
    }

    /**
     * Hàm kiểm tra sự trùng lặp ngày thuê xe
     */

    public static function checkBookingDateConflict($car_id, $pickup_date, $return_date)
    {
        return self::where('car_id', $car_id)
            ->whereHas('booking', function ($query) {
                // Kiểm tra trạng thái của booking khác "Đã hủy"
                $query->where('status', '!=', 'Đã hủy');
            })
            ->where(function ($query) use ($pickup_date, $return_date) {
                // Kiểm tra sự trùng lặp giữa thời gian pickup và thời gian trả xe
                $query->whereHas('pickupAddress', function ($query) use ($pickup_date, $return_date) {
                    $query->where(function ($query) use ($pickup_date, $return_date) {
                        // Nếu ngày pickup mới trùng với khoảng thời gian đã đặt
                        $query->whereDate('pickup_time', '>=', $pickup_date)
                            ->whereDate('pickup_time', '<=', $return_date);
                    });
                })
                    ->orWhereHas('returnAddress', function ($query) use ($pickup_date, $return_date) {
                        $query->where(function ($query) use ($pickup_date, $return_date) {
                            // Kiểm tra nếu ngày trả xe mới có trùng với thời gian đã đặt
                            $query->whereDate('return_time', '>=', $pickup_date)
                                ->whereDate('return_time', '<=', $return_date);
                        });
                    })
                    ->orWhere(function ($query) use ($pickup_date, $return_date) {
                        // Trường hợp đặc biệt: nếu pickup_time và return_time không trùng chính xác, nhưng có sự chồng lấp
                        $query->whereHas('pickupAddress', function ($query) use ($pickup_date) {
                            $query->where('pickup_time', '<=', $pickup_date);
                        })->whereHas('returnAddress', function ($query) use ($return_date) {
                            $query->where('return_time', '>=', $return_date);
                        });
                    });
            })
            ->exists(); // Kiểm tra sự tồn tại của sự trùng lặp
    }
}
