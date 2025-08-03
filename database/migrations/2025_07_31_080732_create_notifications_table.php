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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('member_id')->constrained('members', 'member_id');
            $table->string('title', 100);
            $table->text('message');
            $table->enum('method', ['Email', 'SMS', 'Portal']);
            $table->dateTime('sent_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
