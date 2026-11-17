<?php

namespace App\Services;

use App\Enums\ChannelType;
use App\Enums\DraftStatus;
use App\Models\ChannelDraft;
use App\Models\ContentSource;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DraftGenerationService
{
    public function __construct(private ModuleManager $modules) {}

    public function generateForSource(ContentSource $source, array $channels, ?User $author = null): Collection
    {
        $this->modules->guard('multi_channel_drafts');

        $voice = $source->brandVoice;
        $tone = $voice?->tone ?? 'clear and confident';
        $base = $source->cleaned_transcript ?: $source->original_body ?: $source->summary;

        return collect($channels)->map(function (string $channel) use ($source, $author, $tone, $base, $voice) {
            $channelEnum = ChannelType::tryFrom($channel) ?? ChannelType::LinkedIn;
            $title = "{$channelEnum->label()}: {$source->title}";
            $hook = "From our {$source->source_type->label()} — {$source->title}";
            $body = $this->composeBody($channelEnum, $source, $base, $tone);
            $cta = $voice?->cta_style ?? 'Subscribe for the next breakdown';

            return ChannelDraft::query()->create([
                'content_source_id' => $source->id,
                'brand_voice_id' => $source->brand_voice_id,
                'author_id' => $author?->id,
                'channel' => $channelEnum->value,
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::lower(Str::random(4)),
                'body' => $body,
                'hook' => $hook,
                'cta' => $cta,
                'hashtags' => $this->hashtagsFor($channelEnum),
                'status' => DraftStatus::Draft->value,
                'ai_score' => round(0.72 + (mt_rand(0, 20) / 100), 2),
                'word_count' => str_word_count(strip_tags($body)),
            ]);
        });
    }

    private function composeBody(ChannelType $channel, ContentSource $source, ?string $base, string $tone): string
    {
        $snippet = Str::limit(strip_tags((string) $base), 420);
        $summary = $source->summary ?: $snippet;

        return match ($channel) {
            ChannelType::LinkedIn => "Hook: {$summary}\n\nKey takeaways (tone: {$tone}):\n1) Reframe the problem\n2) Share one proof point\n3) Invite a reply\n\n{$snippet}",
            ChannelType::X => Str::limit("{$summary} — {$tone}. Thread starter.", 260),
            ChannelType::Newsletter => "Subject angle: {$source->title}\n\nOpening ({$tone}):\n{$summary}\n\nBody excerpt:\n{$snippet}\n\nPS: Forward to a teammate who owns distribution.",
            ChannelType::YouTube => "Cold open: {$summary}\n\nChapters:\n00:00 Context\n01:20 Framework\n04:10 Examples\n07:00 CTA\n\nScript notes ({$tone}):\n{$snippet}",
            ChannelType::Blog => "# {$source->title}\n\n{$summary}\n\n## Expanded narrative\n{$snippet}\n\n## Practical checklist\n- Capture the core claim\n- Add one story\n- Close with a measurable CTA",
            ChannelType::ShortForm => "On-screen text: {$summary}\nBeat 1: problem\nBeat 2: twist\nBeat 3: CTA\nTone: {$tone}",
            ChannelType::Threads => "1/ {$summary}\n2/ Why it matters for operators\n3/ One tactic you can ship today\nTone: {$tone}",
            ChannelType::Carousel => "Slide 1: {$source->title}\nSlide 2: Problem\nSlide 3: Framework\nSlide 4: Example\nSlide 5: CTA\nVoice: {$tone}",
        };
    }

    private function hashtagsFor(ChannelType $channel): array
    {
        return match ($channel) {
            ChannelType::LinkedIn => ['ContentOps', 'AIMarketing', 'Repurpose'],
            ChannelType::X => ['BuildInPublic', 'ContentAI'],
            ChannelType::Newsletter => ['WeeklyDigest'],
            default => ['RepurposeAI'],
        };
    }
}