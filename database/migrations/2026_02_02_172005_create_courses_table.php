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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('thumbnail');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
