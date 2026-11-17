<?php

namespace App\Filament\Widgets;

use App\Models\CalendarItem;
use App\Models\ChannelDraft;
use App\Models\ContentSource;
use App\Models\SeoPack;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RepurposeStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Sources Ingested', ContentSource::query()->count())
                ->description('Webinars, blogs, podcasts')
                ->color('primary'),
            Stat::make('Channel Drafts', ChannelDraft::query()->count())
                ->description('Multi-channel assets')
                ->color('success'),
            Stat::make('Calendar Slots', CalendarItem::query()->whereDate('scheduled_at', '>=', today())->count())
                ->description('Upcoming publish windows')
                ->color('warning'),
            Stat::make('SEO Packs Ready', SeoPack::query()->where('status', 'ready')->count())
                ->description('Keyword + meta bundles')
                ->color('danger'),
        ];
    }
}