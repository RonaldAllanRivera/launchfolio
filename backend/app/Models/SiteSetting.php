<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'logo_path',
        'favicon_path',
        'primary_domain',
        'custom_domain',
    ];
}
