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
            $table->string('user_id');
            $table->string('counselor_id')->nullable();
            $table->string('patient_name');
            $table->string('contact_number');
            $table->string('patient_email')->nullable();
            $table->string('service');
            $table->string('address')->nullable();
            $table->date('appointment_date');
            $table->string('appointment_time', 15); // HH:MM format
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->text('notes')->nullable();
            $table->string('preferred_contact')->default('Video Call');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->onDelete('cascade');
            $table->foreign('counselor_id')->references('id')->nullable()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};