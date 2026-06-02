<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE appointments MODIFY COLUMN contact_number VARCHAR(20) NULL DEFAULT ""');
    }

    public function down()
    {
        DB::statement('ALTER TABLE appointments MODIFY COLUMN contact_number VARCHAR(20) NOT NULL');
    }
};