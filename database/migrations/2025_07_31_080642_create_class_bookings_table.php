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
        Schema::create('class_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('class_id');
            $table->enum('status', ['Booked', 'Cancelled', 'Waitlisted']);
            $table->date('booking_date')->default(DB::raw('CURRENT_DATE'));
            $table->primary(['member_id', 'class_id']);
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
            $table->index('class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_bookings');
    }
};
