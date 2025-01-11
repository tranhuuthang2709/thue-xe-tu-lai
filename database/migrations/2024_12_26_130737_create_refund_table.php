<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name');
            $table->decimal('refund_amount', 15, 2);
            $table->string('status');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
