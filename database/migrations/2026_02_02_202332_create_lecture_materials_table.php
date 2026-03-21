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
        Schema::create('lecture_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')->constrained('course_lectures')->cascadeOnDelete();
            $table->string('file_name'); // e.g., 'pdf', 'doc',
            $table->string('file_path');
            $table->string('file_type'); // e.g., 'application/pdf'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_materials');
    }
};
