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
        //báo cáo hư hỏng
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_detail_id');
            $table->foreign('booking_detail_id')->references('id')->on('bookings_detail')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('damage_description');
            $table->decimal('damage_cost', 11, 2);
            $table->enum('payment_status', ['successful', 'failed', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_reports');
    }
};
