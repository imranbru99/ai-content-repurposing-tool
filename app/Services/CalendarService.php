<?php

namespace App\Services;

use App\Enums\DraftStatus;
use App\Models\CalendarItem;
use App\Models\ChannelDraft;
use App\Models\User;
use Carbon\CarbonInterface;

class CalendarService
{
    public function __construct(private ModuleManager $modules) {}

    public function scheduleDraft(ChannelDraft $draft, CarbonInterface $when, ?User $owner = null, ?string $notes = null): CalendarItem
    {
        $this->modules->guard('content_calendar');

        $draft->update([
            'status' => DraftStatus::Scheduled->value,
            'scheduled_for' => $when,
        ]);

        return CalendarItem::query()->create([
            'content_source_id' => $draft->content_source_id,
            'channel_draft_id' => $draft->id,
            'owner_id' => $owner?->id,
            'title' => $draft->title,
            'channel' => $draft->channel instanceof \BackedEnum ? $draft->channel->value : $draft->channel,
            'status' => DraftStatus::Scheduled->value,
            'scheduled_at' => $when,
            'timezone' => 'UTC',
            'notes' => $notes,
        ]);
    }
}
