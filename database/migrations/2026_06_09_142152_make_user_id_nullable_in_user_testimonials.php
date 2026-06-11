<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Support\Facades\DB;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         DB::statement("
//             ALTER TABLE user_testimonials
//             MODIFY user_id BIGINT UNSIGNED NULL
//         ");
//     }

//     public function down(): void
//     {
//         DB::statement("
//             ALTER TABLE user_testimonials
//             MODIFY user_id BIGINT UNSIGNED NOT NULL
//         ");
//     }
// };



use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL syntax to make a column nullable
        DB::statement("ALTER TABLE user_testimonials ALTER COLUMN user_id DROP NOT NULL");
    }

    public function down(): void
    {
        // PostgreSQL syntax to make a column required again
        DB::statement("ALTER TABLE user_testimonials ALTER COLUMN user_id SET NOT NULL");
    }
};