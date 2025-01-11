<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings_detail', function (Blueprint $table) {
            $table->id(); // Mã chi tiết đơn đặt (Primary Key)
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->unsignedBigInteger('pickup_address_id')->nullable();
            $table->foreign('pickup_address_id')->references('id')->on('address')->onDelete('cascade');
            $table->unsignedBigInteger('return_address_id');
            $table->foreign('return_address_id')->references('id')->on('address')->onDelete('cascade');
            $table->decimal('rental_price', 11, 2); // Giá thuê xe
            $table->string('status'); // Trạng thái của chi tiết đơn đặt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings_detail'); // Xóa bảng 'bookings_detail' nếu nó tồn tại
    }
};
