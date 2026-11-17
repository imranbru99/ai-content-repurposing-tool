<?php

namespace App\Services;

use App\Models\ContentSource;

class AssetExportService
{
    public function __construct(private ModuleManager $modules) {}

    public function exportSummary(ContentSource $source): array
    {
        $this->modules->guard('asset_export');

        return [
            'title' => $source->title,
            'channels' => $source->drafts()->count(),
            'seo_packs' => $source->seoPacks()->count(),
            'calendar_slots' => $source->calendarItems()->count(),
            'format' => 'unicode-pdf-ready',
            'note' => 'Rendered via laravel-unicode-pdf when the export module is enabled.',
        ];
    }
}