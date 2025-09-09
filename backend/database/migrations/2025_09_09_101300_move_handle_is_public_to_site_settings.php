<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns to site_settings
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'handle')) {
                $table->string('handle')->nullable()->after('seo_keywords');
            }
            if (! Schema::hasColumn('site_settings', 'is_public')) {
                $table->boolean('is_public')->default(true)->after('handle');
            }
        });

        // Best-effort data migration (optional): copy first non-null values from profiles
        try {
            $site = DB::table('site_settings')->first();
            if ($site && (is_null($site->handle) || !property_exists($site, 'handle'))) {
                $src = DB::table('profiles')
                    ->select('handle', 'is_public')
                    ->whereNotNull('handle')
                    ->orderBy('id')
                    ->first();
                if ($src) {
                    DB::table('site_settings')->where('id', $site->id)->update([
                        'handle' => $src->handle,
                        'is_public' => (bool) ($src->is_public ?? true),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Drop columns from profiles
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'handle')) {
                $table->dropColumn('handle');
            }
            if (Schema::hasColumn('profiles', 'is_public')) {
                $table->dropColumn('is_public');
            }
        });
    }

    public function down(): void
    {
        // Re-add to profiles
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'handle')) {
                $table->string('handle')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('profiles', 'is_public')) {
                $table->boolean('is_public')->default(true)->after('handle');
            }
        });

        // Drop from site_settings
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'is_public')) {
                $table->dropColumn('is_public');
            }
            if (Schema::hasColumn('site_settings', 'handle')) {
                $table->dropColumn('handle');
            }
        });
    }
};
