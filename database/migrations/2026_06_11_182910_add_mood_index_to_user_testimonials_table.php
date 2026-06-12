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
    Schema::table('user_testimonials', function (Blueprint $table) {
        // 1. First, add the column (nullable in case you already have existing rows)
        $table->string('mood')->nullable();
        
        // 2. Then, add the index to the new column
        $table->index('mood');
    });
}

public function down()
{
    Schema::table('user_testimonials', function (Blueprint $table) {
        // 1. Drop the index first
        $table->dropIndex(['mood']);
        
        // 2. Then drop the column
        $table->dropColumn('mood');
    });
}
};
