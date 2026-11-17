<?php

namespace App\Models;

use App\Enums\SourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ContentSource extends Model
{
    protected $fillable = [
        'owner_id', 'brand_voice_id', 'title', 'slug', 'source_type', 'status', 'source_url',
        'original_body', 'cleaned_transcript', 'summary', 'duration_minutes', 'word_count',
        'language', 'tags', 'metadata', 'ingested_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (ContentSource $source) {
            if (blank($source->slug)) {
                $source->slug = Str::slug($source->title).'-'.Str::lower(Str::random(5));
            }
        });
    }

    protected function casts(): array
    {
        return [
            'source_type' => SourceType::class,
            'tags' => 'array',
            'metadata' => 'array',
            'ingested_at' => 'datetime',
        ];
    }

    public function brandVoice(): BelongsTo
    {
        return $this->belongsTo(BrandVoice::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function drafts(): HasMany
    {
        return $this->hasMany(ChannelDraft::class);
    }

    public function calendarItems(): HasMany
    {
        return $this->hasMany(CalendarItem::class);
    }

    public function seoPacks(): HasMany
    {
        return $this->hasMany(SeoPack::class);
    }
}
