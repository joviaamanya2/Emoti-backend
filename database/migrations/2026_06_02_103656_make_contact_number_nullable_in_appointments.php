<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL syntax to make a column nullable
        DB::statement('ALTER TABLE appointments ALTER COLUMN contact_number DROP NOT NULL');
    }

    public function down(): void
    {
        // PostgreSQL syntax to make a column required again
        DB::statement('ALTER TABLE appointments ALTER COLUMN contact_number SET NOT NULL');
    }
};