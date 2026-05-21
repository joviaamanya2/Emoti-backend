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
        Schema::table('counselors', function (Blueprint $table) {
            $table->string('address')->nullable()->after('phone');
            $table->string('specification')->nullable()->after('specialty'); // e.g., CBT, Anxiety, Trauma
            $table->string('profile_photo')->nullable()->after('specification'); // Professional touch
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counselors', function (Blueprint $table) {
            //
        });
    }
};
