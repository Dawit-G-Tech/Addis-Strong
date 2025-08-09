<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name', 255)->nullable();
            $table->string('email', 100)->unique();
            $table->enum('gender', ['Male', 'Female', 'Rather Not Say'])->nullable();
            $table->date('dob')->nullable();
            $table->date('registration_date')->default(DB::raw('CURRENT_DATE'));
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
