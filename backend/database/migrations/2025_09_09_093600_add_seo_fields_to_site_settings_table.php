<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'seo_title')) {
                $table->string('seo_title', 60)->nullable()->after('slider_images');
            }
            if (! Schema::hasColumn('site_settings', 'seo_description')) {
                $table->string('seo_description', 160)->nullable()->after('seo_title');
            }
            if (! Schema::hasColumn('site_settings', 'seo_keywords')) {
                $table->string('seo_keywords', 255)->nullable()->after('seo_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'seo_keywords')) {
                $table->dropColumn('seo_keywords');
            }
            if (Schema::hasColumn('site_settings', 'seo_description')) {
                $table->dropColumn('seo_description');
            }
            if (Schema::hasColumn('site_settings', 'seo_title')) {
                $table->dropColumn('seo_title');
            }
        });
    }
};
