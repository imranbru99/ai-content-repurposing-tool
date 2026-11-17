<?php

namespace App\Services;

use App\Models\ContentSource;
use App\Models\SeoPack;
use App\Models\User;
use Illuminate\Support\Str;

class SeoPackService
{
    public function __construct(private ModuleManager $modules) {}

    public function build(ContentSource $source, string $primaryKeyword, ?User $creator = null): SeoPack
    {
        $this->modules->guard('seo_packs');

        $title = "SEO pack: {$primaryKeyword}";

        return SeoPack::query()->create([
            'content_source_id' => $source->id,
            'created_by' => $creator?->id,
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(4)),
            'primary_keyword' => $primaryKeyword,
            'secondary_keywords' => [
                "{$primaryKeyword} examples",
                "{$primaryKeyword} playbook",
                "how to {$primaryKeyword}",
            ],
            'meta_title' => Str::limit("{$primaryKeyword} | {$source->title}", 60, ''),
            'meta_description' => Str::limit($source->summary ?: "Actionable guidance on {$primaryKeyword} from {$source->title}", 155, ''),
            'outline' => [
                'Introduction & promise',
                'Problem framing',
                'Framework / steps',
                'Case example',
                'FAQ',
                'CTA',
            ],
            'internal_links' => ['/features', '/modules', '/demo'],
            'search_intent' => 'informational',
            'difficulty_score' => random_int(28, 72),
            'status' => 'ready',
        ]);
    }
}