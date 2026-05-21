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
        // In the generated migration file:
        Schema::create('counselor_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The patient
            $table->foreignId('counselor_id')->constrained()->cascadeOnDelete(); // The counselor
            $table->dateTime('scheduled_at'); // Date and Time combined
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->text('admin_notes')->nullable(); // Private notes for admins
            $table->string('session_screenshot')->nullable(); // The proof of session
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
        Schema::dropIfExists('counselor_sessions');
    }
};
