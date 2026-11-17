<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'content_source_id', 'created_by', 'title', 'slug', 'primary_keyword',
    'secondary_keywords', 'meta_title', 'meta_description', 'outline',
    'internal_links', 'search_intent', 'difficulty_score', 'status',
])]
class SeoPack extends Model
{
    protected function casts(): array
    {
        return [
            'secondary_keywords' => 'array',
            'outline' => 'array',
            'internal_links' => 'array',
            'difficulty_score' => 'integer',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(ContentSource::class, 'content_source_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}