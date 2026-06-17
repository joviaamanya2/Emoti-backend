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
            // Add the boolean column. 
            // default(false) ensures it is hidden until the user accepts.
            $table->boolean('display_on_ui')->default(false)->after('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_testimonials', function (Blueprint $table) {
            $table->dropColumn('display_on_ui');
        });
    }
};