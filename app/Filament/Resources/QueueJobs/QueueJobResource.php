<?php

namespace App\Filament\Resources\QueueJobs;

use App\Filament\Resources\QueueJobs\Pages\ManageQueueJobs;
use App\Models\QueueJob;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class QueueJobResource extends Resource
{
    protected static ?string $model = QueueJob::class;

    protected static ?string $navigationLabel = 'Queue Jobs';

    protected static ?string $modelLabel = 'queue job';

    protected static ?string $pluralModelLabel = 'queue jobs';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static string|UnitEnum|null $navigationGroup = 'Ops';

    protected static ?int $navigationSort = 80;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('queue')->badge()->searchable(),
                TextColumn::make('attempts')->sortable(),
                TextColumn::make('reserved_at')
                    ->label('Reserved')
                    ->formatStateUsing(fn ($state) => $state ? date('Y-m-d H:i', (int) $state) : '—'),
                TextColumn::make('available_at')
                    ->label('Available')
                    ->formatStateUsing(fn ($state) => $state ? date('Y-m-d H:i', (int) $state) : '—'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->formatStateUsing(fn ($state) => $state ? date('Y-m-d H:i', (int) $state) : '—'),
                TextColumn::make('payload')
                    ->label('Job')
                    ->formatStateUsing(function ($state) {
                        $payload = is_array($state) ? $state : (json_decode((string) $state, true) ?: []);
                        $display = $payload['displayName'] ?? $payload['job'] ?? 'Queued job';

                        return is_string($display) ? class_basename($display) : 'Queued job';
                    })
                    ->wrap(),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageQueueJobs::route('/')];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
