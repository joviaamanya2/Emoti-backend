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

            // FIXED: must be foreignId, not string
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('counselor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('patient_name');
            $table->string('contact_number');
            $table->string('patient_email')->nullable();
            $table->string('reason')->nullable();
            $table->string('address')->nullable();

            $table->date('appointment_date');
            $table->string('appointment_time', 15);

            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->string('preferred_contact')->default('Video Call');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};