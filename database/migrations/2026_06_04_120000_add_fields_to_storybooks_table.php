<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('storybooks', function (Blueprint $table) {
            if (! Schema::hasColumn('storybooks', 'age_group')) {
                $table->string('age_group')->nullable()->after('category');
            }

            if (! Schema::hasColumn('storybooks', 'content')) {
                $table->longText('content')->nullable()->after('age_group');
            }

            if (! Schema::hasColumn('storybooks', 'is_featured')) {
                $table->tinyInteger('is_featured')->default(0)->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('storybooks', function (Blueprint $table) {
            if (Schema::hasColumn('storybooks', 'is_featured')) {
                $table->dropColumn('is_featured');
            }

            if (Schema::hasColumn('storybooks', 'content')) {
                $table->dropColumn('content');
            }

            if (Schema::hasColumn('storybooks', 'age_group')) {
                $table->dropColumn('age_group');
            }
        });
    }
};
