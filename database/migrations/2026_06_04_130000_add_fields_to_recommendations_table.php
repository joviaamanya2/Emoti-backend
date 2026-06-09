<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            if (! Schema::hasColumn('recommendations', 'title')) {
                $table->string('title')->nullable()->after('mood_id');
            }

            if (! Schema::hasColumn('recommendations', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (! Schema::hasColumn('recommendations', 'type')) {
                $table->string('type')->nullable()->after('description');
            }

            if (! Schema::hasColumn('recommendations', 'video_path')) {
                $table->string('video_path')->nullable()->after('type');
            }

            if (! Schema::hasColumn('recommendations', 'music_path')) {
                $table->string('music_path')->nullable()->after('video_path');
            }

            if (! Schema::hasColumn('recommendations', 'tips_text')) {
                $table->longText('tips_text')->nullable()->after('music_path');
            }

            if (! Schema::hasColumn('recommendations', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('tips_text');
            }

            if (! Schema::hasColumn('recommendations', 'file')) {
                $table->string('file')->nullable()->after('is_active');
            }

            if (! Schema::hasColumn('recommendations', 'link')) {
                $table->string('link')->nullable()->after('file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            if (Schema::hasColumn('recommendations', 'link')) {
                $table->dropColumn('link');
            }

            if (Schema::hasColumn('recommendations', 'file')) {
                $table->dropColumn('file');
            }

            if (Schema::hasColumn('recommendations', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('recommendations', 'tips_text')) {
                $table->dropColumn('tips_text');
            }

            if (Schema::hasColumn('recommendations', 'music_path')) {
                $table->dropColumn('music_path');
            }

            if (Schema::hasColumn('recommendations', 'video_path')) {
                $table->dropColumn('video_path');
            }

            if (Schema::hasColumn('recommendations', 'type')) {
                $table->dropColumn('type');
            }

            if (Schema::hasColumn('recommendations', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('recommendations', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
