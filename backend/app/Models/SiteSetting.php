<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'email',
        'phone',
        'address',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'logo_path',
        'favicon_path',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'github_url',
        'about',
    ];
}
