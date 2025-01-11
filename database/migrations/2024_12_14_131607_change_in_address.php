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
        Schema::table('address', function (Blueprint $table) {
            $table->timestamp('pickup_time')->nullable()->change();
            $table->timestamp('return_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('address', function (Blueprint $table) {
            //
        });
    }
};
