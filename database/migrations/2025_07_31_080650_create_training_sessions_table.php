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
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id('session_id');
            $table->foreignId('member_id')->constrained('members', 'member_id');
            $table->foreignId('trainer_id')->constrained('users', 'user_id');
            $table->dateTime('session_time');
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled']);
            $table->text('notes')->nullable();
            $table->index('trainer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
