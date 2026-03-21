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
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            // Gateway Info
            $table->string('gateway')->default('meezan'); // meezan, jazzcash, stripe
            $table->string('transaction_id')->nullable();
            $table->string('reference_no')->nullable();
            // Amount
            $table->decimal('amount', 10, 2);
            // Status
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled'])->default('pending');

            // Gateway Response
            $table->json('gateway_response')->nullable();
            $table->timestamps();
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
