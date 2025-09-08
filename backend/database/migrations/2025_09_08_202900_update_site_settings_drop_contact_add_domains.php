<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Drop duplicate contact/about fields (Profiles is source of truth)
            if (Schema::hasColumn('site_settings', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('site_settings', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('site_settings', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('site_settings', 'about')) {
                $table->dropColumn('about');
            }

            // Add SaaS domain fields
            if (! Schema::hasColumn('site_settings', 'primary_domain')) {
                $table->string('primary_domain')->nullable()->after('favicon_path');
            }
            if (! Schema::hasColumn('site_settings', 'custom_domain')) {
                $table->string('custom_domain')->nullable()->after('primary_domain');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            // Re-add dropped fields
            if (! Schema::hasColumn('site_settings', 'email')) {
                $table->string('email')->nullable()->after('tagline');
            }
            if (! Schema::hasColumn('site_settings', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('site_settings', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('site_settings', 'about')) {
                $table->longText('about')->nullable()->after('favicon_path');
            }

            // Drop domain fields
            if (Schema::hasColumn('site_settings', 'custom_domain')) {
                $table->dropColumn('custom_domain');
            }
            if (Schema::hasColumn('site_settings', 'primary_domain')) {
                $table->dropColumn('primary_domain');
            }
        });
    }
};
