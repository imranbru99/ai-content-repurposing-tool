<?php

namespace App\Services;

use App\Models\BrandVoice;
use Illuminate\Support\Str;

class BrandVoiceService
{
    public function __construct(private ModuleManager $modules) {}

    public function create(array $payload): BrandVoice
    {
        $this->modules->guard('brand_voice');

        $name = (string) ($payload['name'] ?? 'Default Voice');

        if (! empty($payload['is_default'])) {
            BrandVoice::query()->where('is_default', true)->update(['is_default' => false]);
        }

        return BrandVoice::query()->create([
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(3)),
            'tone' => $payload['tone'] ?? 'authoritative + warm',
            'audience' => $payload['audience'] ?? 'marketing leaders',
            'cta_style' => $payload['cta_style'] ?? 'Book a working session',
            'banned_phrases' => $payload['banned_phrases'] ?? ['synergy', 'disrupt'],
            'preferred_phrases' => $payload['preferred_phrases'] ?? ['ship value', 'operator-ready'],
            'sample_paragraph' => $payload['sample_paragraph'] ?? 'We turn long-form expertise into channel-ready assets without losing the point of view.',
            'locale' => $payload['locale'] ?? 'en',
            'is_default' => (bool) ($payload['is_default'] ?? false),
            'is_active' => (bool) ($payload['is_active'] ?? true),
        ]);
    }
}