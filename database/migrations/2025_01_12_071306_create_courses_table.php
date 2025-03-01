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
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->string('title');
            $table->longText('description');
            $table->string('image');
            $table->string('slug')->unique();
            $table->string('location');
            $table->string('rating')->nullable();
            $table->timestamp('apply_start');
            $table->timestamp('apply_end');
            $table->timestamp('course_start');
            $table->timestamp('course_end');
            $table->foreignId('manager_id')->constrained('managers');
            $table->timestamps();
            $table->softDeletes();
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
