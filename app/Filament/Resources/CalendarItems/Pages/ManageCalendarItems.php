<?php

namespace App\Filament\Resources\CalendarItems\Pages;

use App\Filament\Resources\CalendarItems\CalendarItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCalendarItems extends ManageRecords
{
    protected static string $resource = CalendarItemResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTitle(): string
    {
        return 'Content Calendar';
    }
}