<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_bridge_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('alumni_id')->constrained('users');
            $table->text('question');
            $table->text('answer')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('status')->default('pending'); // pending, answered
            $table->datetime('answered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_bridge_questions');
    }
};