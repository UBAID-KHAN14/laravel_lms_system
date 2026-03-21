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
        Schema::create('term_and_privacies', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['privacies', 'terms']);
            $table->string('heading');
            $table->text('body');
            $table->integer('sort_order');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_and_privacies');
    }
};
