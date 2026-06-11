<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 👉 Skip if the column already exists
        if (!Schema::hasColumn('user_testimonials', 'emoji')) {
            Schema::table('user_testimonials', function (Blueprint $table) {
                $table->string('emoji')->nullable()->after('description');
            });
        }
    }

    public function down(): void
    {
        // 👉 Only drop if the column exists
        if (Schema::hasColumn('user_testimonials', 'emoji')) {
            Schema::table('user_testimonials', function (Blueprint $table) {
                $table->dropColumn('emoji');
            });
        }
    }
};