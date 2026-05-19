<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storybooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('reader')->default('');
            $table->string('image', 500)->default('');
            $table->json('pages');
            $table->string('category')->default('General');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('created_at')->useCurrent();

            $table->index('is_active', 'idx_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storybooks');
    }
};
