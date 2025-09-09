<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'site_name')) {
                $table->dropColumn('site_name');
            }
            if (Schema::hasColumn('site_settings', 'tagline')) {
                $table->dropColumn('tagline');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'site_name')) {
                $table->string('site_name')->nullable()->after('id');
            }
            if (! Schema::hasColumn('site_settings', 'tagline')) {
                $table->string('tagline')->nullable()->after('site_name');
            }
        });
    }
};
