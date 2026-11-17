<?php

namespace App\Models;

use App\Enums\ChannelType;
use App\Enums\DraftStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'content_source_id', 'brand_voice_id', 'author_id', 'channel', 'title', 'slug',
    'body', 'hook', 'cta', 'hashtags', 'status', 'ai_score', 'word_count',
    'scheduled_for', 'published_at',
])]
class ChannelDraft extends Model
{
    protected function casts(): array
    {
        return [
            'channel' => ChannelType::class,
            'status' => DraftStatus::class,
            'hashtags' => 'array',
            'ai_score' => 'float',
            'word_count' => 'integer',
            'scheduled_for' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(ContentSource::class, 'content_source_id');
    }

    public function brandVoice(): BelongsTo
    {
        return $this->belongsTo(BrandVoice::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function calendarItems(): HasMany
    {
        return $this->hasMany(CalendarItem::class);
    }
}