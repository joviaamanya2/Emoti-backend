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
        Schema::create('user_testimonials', function (Blueprint $table) {
            $table->id();
            
            // User relationship (nullable in case guests or unauthenticated users submit)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('user_name')->nullable();
            $table->string('session_type')->nullable();
            $table->string('what_worked')->nullable();
            $table->text('description')->nullable();
            
            // Added emoji since it's in your Controller's validation, but not currently saved!
            $table->string('emoji')->nullable(); 
            
            $table->integer('star_rating')->nullable()->default(5);
            $table->string('mood_when_it_worked')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->integer('helpful_count')->default(0);
            
            // Required because your Controller sorts by created_at and calculates daysAgo
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_testimonials');
    }
};