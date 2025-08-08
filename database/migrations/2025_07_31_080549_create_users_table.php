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
            $table->id('user_id');
            $table->string('first_name', 100)->default('');
            $table->string('last_name', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Rather Not Say'])->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->date('registration_date')->default(DB::raw('CURRENT_DATE'));
            $table->string('hashed_password');
            $table->string('profile_picture')->nullable();
            $table->timestamps('created_at')->nullable();
            $table->timestamps('updated_at')->nullable();
            $table->foreignId('role_id')->constrained('roles', 'role_id');
            $table->enum('status', ['Active', 'Inactive', 'Banned'])->default('Active');
            $table->index('email');
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
