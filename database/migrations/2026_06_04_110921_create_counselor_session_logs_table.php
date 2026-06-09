<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counselor_session_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade');
            $table->string('counselor_name');
            $table->string('counselor_email');
            $table->string('counselor_contact');
            $table->string('client_name');
            $table->string('specification');
            $table->text('session_notes')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counselor_session_logs');
    }
};