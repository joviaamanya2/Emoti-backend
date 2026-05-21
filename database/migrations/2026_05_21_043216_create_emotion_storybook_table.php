<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emotion_storybook', function (Blueprint $table) {
            $table->id();

            $table->foreignId('storybook_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('emotion_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emotion_storybook');
    }
};