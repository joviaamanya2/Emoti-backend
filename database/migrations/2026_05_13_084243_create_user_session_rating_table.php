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
        Schema::create('session_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 255);
            $table->string('session_type', 100);
            $table->string('session_title', 255)->default('');
            $table->tinyInteger('emoji_rating')->default(0);
            $table->tinyInteger('star_rating')->default(0);
            $table->text('feedback_text')->nullable();
            $table->string('mood_at_start', 50)->default('');
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id', 'idx_user');
            $table->index('session_type', 'idx_type');
            $table->index('created_at', 'idx_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_ratings');
    }
};