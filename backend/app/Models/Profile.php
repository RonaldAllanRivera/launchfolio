<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_initial',
        'last_name',
        'headline',
        'summary',
        'photo_path',
        'banner_path',
        'location_city',
        'location_country',
        'state_province',
        'industry',
        'website_url',
        'linkedin_url',
        'github_url',
        'twitter_url',
        'contact_email',
        'phone',
        'handle',
        'is_public',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderBy('sort_order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('sort_order');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class)->orderBy('sort_order');
    }

    public function getFullNameAttribute(): string
    {
        $mi = trim((string) ($this->middle_initial ?? ''));
        // Format as "First M. Last" if middle initial provided (adds a dot if missing)
        if ($mi !== '') {
            $mi = rtrim($mi, '.');
            $mi .= '.';
            return trim(($this->first_name ?: '') . ' ' . $mi . ' ' . ($this->last_name ?: ''));
        }
        return trim(($this->first_name ?: '') . ' ' . ($this->last_name ?: ''));
    }
}
