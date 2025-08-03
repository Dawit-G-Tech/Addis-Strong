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
        Schema::create('access_control', function (Blueprint $table) {
            $table->id('access_id');
            $table->foreignId('member_id')->constrained('members', 'member_id');
            $table->string('area_name', 100);
            $table->boolean('access_granted')->default(true);
            $table->text('reason')->nullable();
            $table->index('area_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_control');
    }
};
