<?php

namespace App\Filament\Resources\ChannelDrafts\Pages;

use App\Filament\Resources\ChannelDrafts\ChannelDraftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageChannelDrafts extends ManageRecords
{
    protected static string $resource = ChannelDraftResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getTitle(): string
    {
        return 'Channel Drafts';
    }
}