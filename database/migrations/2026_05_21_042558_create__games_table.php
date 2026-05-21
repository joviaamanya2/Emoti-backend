<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // quiz, memory, matching, etc.
            $table->string('type');

            $table->string('difficulty')->default('easy');

            $table->string('target_emotion')->nullable();

            $table->text('description')->nullable();

            $table->string('game_url')->nullable();

            $table->integer('estimated_duration')->nullable();

            $table->string('age_group')->default('all');

            $table->boolean('is_featured')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};