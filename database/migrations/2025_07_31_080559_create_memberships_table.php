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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id('membership_id');
            $table->string('name', 50);
            $table->integer('duration_months');
            $table->decimal('price', 10, 2);
            $table->enum('access_level', ['Basic', 'Standard', 'Premium']);
            $table->enum('status', ['active', 'expired', 'renewal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
