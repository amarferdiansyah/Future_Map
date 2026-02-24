<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('type'); // webinar, workshop, jobfair, seminar
            $table->string('banner')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('location')->nullable();
            $table->string('online_url')->nullable();
            $table->integer('max_participants')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->decimal('price', 15, 2)->nullable();
            $table->json('speakers')->nullable();
            $table->string('qrcode_token')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};