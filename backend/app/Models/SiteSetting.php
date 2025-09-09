<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'logo_path',
        'favicon_path',
        'primary_domain',
        'custom_domain',
        'slider_images',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'handle',
        'is_public',
    ];

    protected $casts = [
        'slider_images' => 'array',
        'is_public' => 'bool',
    ];
}
