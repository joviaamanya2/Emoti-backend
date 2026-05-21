<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToCounselorsTable extends Migration
{
    public function up()
    {
        Schema::table('counselors', function (Blueprint $table) {
            // Add the status column (boolean: 1 = Active, 0 = Inactive)
            if (!Schema::hasColumn('counselors', 'status')) {
                $table->boolean('status')->default(1)->after('specialty');
            }

            // Add the specification column
            if (!Schema::hasColumn('counselors', 'specification')) {
                $table->string('specification')->nullable()->after('specialty');
            }

            // Add the address column
            if (!Schema::hasColumn('counselors', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }

            // Add the profile photo column
            if (!Schema::hasColumn('counselors', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('address');
            }
        });
    }

    public function down()
    {
        Schema::table('counselors', function (Blueprint $table) {
            $table->dropColumn(['status', 'specification', 'address', 'profile_photo']);
        });
    }
}