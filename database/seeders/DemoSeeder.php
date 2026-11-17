<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\BrandVoiceService;
use App\Services\CalendarService;
use App\Services\DraftGenerationService;
use App\Services\ModuleManager;
use App\Services\SeoPackService;
use App\Services\SourceIngestService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleManager::class)->syncFromConfig();

        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@repurposeai.test', 'role' => UserRole::SuperAdmin, 'job_title' => 'Platform Owner'],
            ['name' => 'Content Admin', 'email' => 'admin@repurposeai.test', 'role' => UserRole::Admin, 'job_title' => 'Head of Content'],
            ['name' => 'Editorial Manager', 'email' => 'manager@repurposeai.test', 'role' => UserRole::Manager, 'job_title' => 'Editorial Manager'],
            ['name' => 'Staff Editor', 'email' => 'staff@repurposeai.test', 'role' => UserRole::Staff, 'job_title' => 'Content Editor'],
            ['name' => 'Agency Client', 'email' => 'client@repurposeai.test', 'role' => UserRole::Client, 'job_title' => 'Marketing Lead'],
            ['name' => 'Demo User', 'email' => 'demo@repurposeai.test', 'role' => UserRole::Demo, 'job_title' => 'Demo Editor'],
        ];

        $created = [];
        foreach ($users as $data) {
            $created[$data['role']->value] = User::query()->updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'phone' => '+1-555-0199',
                    'job_title' => $data['job_title'],
                    'organization_name' => 'RepurposeAI Studio',
                    'is_demo' => $data['role'] === UserRole::Demo,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        $editor = $created[UserRole::Staff->value];
        $manager = $created[UserRole::Manager->value];
        $demo = $created[UserRole::Demo->value];

        $voiceService = app(BrandVoiceService::class);
        $defaultVoice = $voiceService->create([
            'name' => 'Operator Magenta',
            'tone' => 'authoritative + warm',
            'audience' => 'B2B marketing & content ops leaders',
            'cta_style' => 'Ship the next asset this week',
            'banned_phrases' => ['synergy', 'hack growth', 'disrupt'],
            'preferred_phrases' => ['channel-ready', 'operator-ready', 'publish with confidence'],
            'sample_paragraph' => 'We turn webinars, blogs, and podcasts into multi-channel assets, calendars, and SEO-ready drafts without losing brand voice.',
            'is_default' => true,
        ]);

        $voiceService->create([
            'name' => 'Founder Casual',
            'tone' => 'candid + practical',
            'audience' => 'startup founders',
            'cta_style' => 'Try the demo workspace',
            'is_default' => false,
        ]);

        $ingest = app(SourceIngestService::class);
        $drafts = app(DraftGenerationService::class);
        $calendar = app(CalendarService::class);
        $seo = app(SeoPackService::class);

        $sources = [
            [
                'title' => 'Webinar: Content Ops Without Burnout',
                'source_type' => 'webinar',
                'source_url' => 'https://example.com/webinars/content-ops',
                'duration_minutes' => 48,
                'tags' => ['webinar', 'ops'],
                'original_body' => "[00:01] Welcome everyone. Um, today we cover how teams repurpose long-form sessions. You know, the goal is fewer blank pages and more scheduled assets. Framework: capture, clean, draft, calendar, SEO pack.",
                'summary' => 'A 48-minute webinar on building a repeatable content repurposing operating system.',
            ],
            [
                'title' => 'Podcast: Distribution Beats Perfection',
                'source_type' => 'podcast',
                'duration_minutes' => 32,
                'tags' => ['podcast', 'distribution'],
                'original_body' => 'Hosts discuss why shipping channel variants weekly beats waiting for perfect blog posts. Key idea: one source should fund LinkedIn, newsletter, and short-form.',
                'summary' => 'Podcast episode arguing for distribution-first editorial calendars.',
            ],
            [
                'title' => 'Blog: SEO Drafts From Expert Interviews',
                'source_type' => 'blog',
                'source_url' => 'https://example.com/blog/seo-from-interviews',
                'tags' => ['blog', 'seo'],
                'original_body' => 'Expert interviews contain keyword-rich answers. Extract primary claims, build an outline, then produce meta titles and derivative posts for each channel.',
                'summary' => 'How interview transcripts become SEO packs and multi-channel drafts.',
            ],
        ];

        foreach ($sources as $i => $payload) {
            $source = $ingest->ingest(array_merge($payload, [
                'brand_voice_id' => $defaultVoice->id,
                'owner_id' => $editor->id,
            ]), $editor);

            $channels = match ($i) {
                0 => ['linkedin', 'newsletter', 'youtube', 'carousel'],
                1 => ['x', 'short_form', 'threads', 'linkedin'],
                default => ['blog', 'newsletter', 'linkedin'],
            };

            $generated = $drafts->generateForSource($source, $channels, $demo);

            foreach ($generated->values() as $index => $draft) {
                $when = now()->addDays($index + 1)->setTime(9 + $index, 0);
                $calendar->scheduleDraft($draft, $when, $manager, 'Demo calendar slot');
            }

            $seo->build($source, match ($i) {
                0 => 'content repurposing workflow',
                1 => 'content distribution calendar',
                default => 'seo content drafts from interviews',
            }, $manager);
        }
    }
}
