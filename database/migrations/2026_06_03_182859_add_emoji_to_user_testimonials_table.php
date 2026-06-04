<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_testimonials', function (Blueprint $table) {
            // Add the emoji column after the description column
            $table->string('emoji')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_testimonials', function (Blueprint $table) {
            $table->dropColumn('emoji');
        });
    }
};