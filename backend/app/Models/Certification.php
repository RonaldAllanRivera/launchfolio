<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $fillable = [
        'profile_id',
        'title',
        'issuer',
        'issued_on',
        'pdf_path',
        'image_path',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'issued_on' => 'date',
        'is_published' => 'boolean',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
