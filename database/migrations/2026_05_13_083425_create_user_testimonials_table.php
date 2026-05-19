<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 255);
            $table->string('user_name', 100)->default('Anonymous');
            $table->string('session_type', 100)->default('General');
            $table->text('what_worked');
            $table->text('description')->nullable();
            $table->tinyInteger('star_rating')->default(5);
            $table->string('mood_when_it_worked', 50)->default('');
            $table->tinyInteger('is_approved')->default(0);
            $table->integer('helpful_count')->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id', 'idx_user');
            $table->index('is_approved', 'idx_approved');
            $table->index('session_type', 'idx_type');
            $table->index('created_at', 'idx_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_testimonials');
    }
};