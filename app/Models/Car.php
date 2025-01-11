<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = [
        'user_id',
        'brand_id',
        'category_id',
        'address_id',
        'name',
        'main_image',
        'price',
        'discounted_price',
        'seat',
        'manufacture_year',
        'description',
        'fuel_type',
        'color',
        'status',
        'license_plate',
        'total_km_driven',
        'transmission'
    ];
    public function getStatusAttribute($value)
    {
        $statusLabels = [
            'available' => 'Có sẵn',
            'rented' => 'Đang thuê',
            'under_maintenance' => 'Đang bảo trì'
        ];

        return $statusLabels[$value] ?? $value;
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Quan hệ với mô hình Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'car_id', 'user_id');
    }
    public function bookingsdetail()
    {
        return $this->hasMany(Booking_detail::class);
    }
}
