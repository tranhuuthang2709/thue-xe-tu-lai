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
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Mã xe (Primary Key)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
            $table->string('name'); // Tên xe
            $table->string('main_image'); // Ảnh chính
            $table->integer('seat');
            $table->decimal('price', 11, 2); // Giá thuê theo ngày
            $table->decimal('discounted_price', 11, 2); // Giá thuê theo ngày đã giảm giá
            $table->year('manufacture_year'); // Năm sản xuất
            $table->text('description'); // Mô tả xe
            $table->string('fuel_type'); // Loại nhiên liệu xăng, dầu , điện
            $table->string('color'); // Màu sắc
            $table->string('status'); // Tình trạng (Có sẵn, Đang thuê, Đang bảo trì)
            $table->string('license_plate'); // Biển số xe
            $table->string('transmission'); // Hộp số (Số tự động,Số sàn)
            $table->timestamps(); // Timestamps: Created at, Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
