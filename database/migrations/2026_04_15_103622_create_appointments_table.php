<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // If you have users table (client/student)
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Link to counselors table
            $table->foreignId('counselor_id')
                ->constrained('counselors')
                ->onDelete('cascade');

            // Appointment details
            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->enum('status', ['pending', 'approved', 'cancelled', 'completed'])
                ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};