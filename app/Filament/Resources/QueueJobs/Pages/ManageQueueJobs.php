<?php

namespace App\Filament\Resources\QueueJobs\Pages;

use App\Filament\Resources\QueueJobs\QueueJobResource;
use Filament\Resources\Pages\ManageRecords;

class ManageQueueJobs extends ManageRecords
{
    protected static string $resource = QueueJobResource::class;

    public function getTitle(): string
    {
        return 'Queue Jobs';
    }
}
