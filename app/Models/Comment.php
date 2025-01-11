<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'car_id', 'content'];

    // Quan hệ với người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với xe
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
