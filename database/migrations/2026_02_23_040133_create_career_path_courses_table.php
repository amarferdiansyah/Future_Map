<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_path_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_path_id')->constrained()->onDelete('cascade');
            $table->string('course_name');
            $table->string('course_code')->nullable();
            $table->string('university')->nullable();
            $table->string('platform')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_path_courses');
    }
};