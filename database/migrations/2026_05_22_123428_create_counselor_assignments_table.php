<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('counselor_assignments', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counselor_id')->constrained()->cascadeOnDelete();

            // Assignment Details
            $table->dateTime('scheduled_at');
            $table->enum('session_type', ['online', 'physical'])->default('online');

            $table->string('status')->default('pending');

            $table->text('rejection_reason')->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('status_updated_at')->nullable();

            $table->timestamps();

            // Prevent duplicate scheduling
            $table->unique(['user_id', 'scheduled_at'], 'unique_user_schedule');
        });
    }

    public function down()
    {
        Schema::dropIfExists('counselor_assignments');
    }
};