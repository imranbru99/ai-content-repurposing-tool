<?php

namespace App\Services;

use App\Enums\SourceType;
use App\Models\BrandVoice;
use App\Models\ContentSource;
use App\Models\User;
use Illuminate\Support\Str;

class SourceIngestService
{
    public function __construct(private ModuleManager $modules) {}

    public function ingest(array $payload, ?User $owner = null): ContentSource
    {
        $this->modules->guard('source_ingest');

        $title = (string) ($payload['title'] ?? 'Untitled source');
        $body = (string) ($payload['original_body'] ?? '');
        $cleaned = $body;

        if ($this->modules->enabled('transcript_cleanup') && filled($body)) {
            $cleaned = app(TranscriptCleanupService::class)->clean($body);
        }

        return ContentSource::query()->create([
            'owner_id' => $owner?->id ?? ($payload['owner_id'] ?? null),
            'brand_voice_id' => $payload['brand_voice_id'] ?? BrandVoice::query()->where('is_default', true)->value('id'),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'source_type' => $payload['source_type'] ?? SourceType::Blog->value,
            'status' => $payload['status'] ?? 'ready',
            'source_url' => $payload['source_url'] ?? null,
            'original_body' => $body,
            'cleaned_transcript' => $cleaned,
            'summary' => $payload['summary'] ?? Str::limit(strip_tags($cleaned ?: $body), 280),
            'duration_minutes' => $payload['duration_minutes'] ?? null,
            'word_count' => str_word_count(strip_tags($cleaned ?: $body)),
            'language' => $payload['language'] ?? 'en',
            'tags' => $payload['tags'] ?? [],
            'metadata' => $payload['metadata'] ?? [],
            'ingested_at' => now(),
        ]);
    }
}