<?php

namespace App\Filament\Resources\ContentSources\Pages;

use App\Filament\Resources\ContentSources\ContentSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContentSources extends ManageRecords
{
    protected static string $resource = ContentSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
