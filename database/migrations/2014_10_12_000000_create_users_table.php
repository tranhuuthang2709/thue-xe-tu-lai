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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Mã người dùng
            $table->string('first_name'); // Họ
            $table->string('last_name'); // Tên
            $table->string('email'); // Email
            $table->timestamp('email_verified_at')->nullable(); // Thời gian xác minh email
            $table->string('password'); // Mật khẩu
            $table->string('phone_number')->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Địa chỉ
            $table->enum('role', ['admin', 'customer', 'employee', 'lessor']); // admin, khách hàng,nhân viên, khách hàng
            $table->string('google_id')->nullable(); // ID Google (nếu đăng nhập qua Google)
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Xóa bảng users
    }
};
