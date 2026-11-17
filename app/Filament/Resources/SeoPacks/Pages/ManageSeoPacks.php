<?php

namespace App\Filament\Resources\SeoPacks\Pages;

use App\Filament\Resources\SeoPacks\SeoPackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSeoPacks extends ManageRecords
{
    protected static string $resource = SeoPackResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTitle(): string
    {
        return 'SEO Packs';
    }
}