<?php

namespace App\Filament\Resources\BrandVoices\Pages;

use App\Filament\Resources\BrandVoices\BrandVoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBrandVoices extends ManageRecords
{
    protected static string $resource = BrandVoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
