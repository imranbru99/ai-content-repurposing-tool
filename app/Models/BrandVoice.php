<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'slug', 'tone', 'audience', 'cta_style', 'banned_phrases',
    'preferred_phrases', 'sample_paragraph', 'locale', 'is_default', 'is_active',
])]
class BrandVoice extends Model
{
    protected function casts(): array
    {
        return [
            'banned_phrases' => 'array',
            'preferred_phrases' => 'array',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function sources(): HasMany
    {
        return $this->hasMany(ContentSource::class);
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(ChannelDraft::class);
    }
}