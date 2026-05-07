<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emotions', function (Blueprint $table) {
            $table->id();
            $table->string('mood'); // e.g., "happy", "sad"
            $table->text('description')->nullable(); // optional description
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emotions');
    }
};