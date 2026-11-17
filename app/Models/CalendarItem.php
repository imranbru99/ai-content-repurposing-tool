<?php

namespace App\Models;

use App\Enums\ChannelType;
use App\Enums\DraftStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'content_source_id', 'channel_draft_id', 'owner_id', 'title', 'channel',
    'status', 'scheduled_at', 'timezone', 'notes',
])]
class CalendarItem extends Model
{
    protected function casts(): array
    {
        return [
            'channel' => ChannelType::class,
            'status' => DraftStatus::class,
            'scheduled_at' => 'datetime',
        ];
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(ContentSource::class, 'content_source_id');
    }

    public function draft(): BelongsTo
    {
        return $this->belongsTo(ChannelDraft::class, 'channel_draft_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}