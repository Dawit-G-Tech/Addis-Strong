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
        Schema::create('equipment', function (Blueprint $table) {
            $table->string('eq_id', 10)->primary();
            $table->string('eq_name', 30);
            $table->integer('quantity');
            $table->string('eq_category', 30);
            $table->string('eq_status', 30)->default('Usable');
            $table->date('date_of_buy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
