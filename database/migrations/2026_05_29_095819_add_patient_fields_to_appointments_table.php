<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            if (!Schema::hasColumn('appointments', 'patient_phone')) {
                $table->string('patient_phone')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'patient_email')) {
                $table->string('patient_email')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'appointment_date')) {
                $table->date('appointment_date')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'appointment_time')) {
                $table->string('appointment_time')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'service')) {
                $table->string('service')->nullable();
            }

            if (!Schema::hasColumn('appointments', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'patient_phone',
                'patient_email',
                'appointment_date',
                'appointment_time',
                'address',
                'notes',
                'service',
                'status',
            ]);
        });
    }
};