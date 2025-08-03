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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('member_id')->constrained('members', 'member_id');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['Cash', 'Card', 'Mobile', 'Bank Transfer']);
            $table->date('payment_date')->default(DB::raw('CURRENT_DATE'));
            $table->date('start_date');
            $table->date('end_date');
            $table->index('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
