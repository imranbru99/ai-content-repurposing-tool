<?php

namespace App\Filament\Widgets;

use App\Models\CalendarItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingCalendarWidget extends TableWidget
{
    protected static ?string $heading = 'Upcoming calendar';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CalendarItem::query()
                    ->where('scheduled_at', '>=', now()->subDay())
                    ->orderBy('scheduled_at')
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('scheduled_at')->dateTime()->sortable(),
                TextColumn::make('title')->limit(42),
                TextColumn::make('channel')->badge(),
                TextColumn::make('status')->badge(),
            ])
            ->paginated(false);
    }
}