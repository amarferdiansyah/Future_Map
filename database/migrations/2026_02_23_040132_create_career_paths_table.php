<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_paths', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('industry');
            $table->decimal('avg_salary_min', 15, 2)->nullable();
            $table->decimal('avg_salary_max', 15, 2)->nullable();
            $table->json('required_skills')->nullable();
            $table->json('recommended_certifications')->nullable();
            $table->text('career_progression')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_paths');
    }
};