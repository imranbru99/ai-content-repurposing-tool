<?php

namespace App\Filament\Resources\FailedJobs;

use App\Filament\Resources\FailedJobs\Pages\ManageFailedJobs;
use App\Models\FailedJob;
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

class FailedJobResource extends Resource
{
    protected static ?string $model = FailedJob::class;

    protected static ?string $navigationLabel = 'Failed Jobs';

    protected static ?string $modelLabel = 'failed job';

    protected static ?string $pluralModelLabel = 'failed jobs';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Ops';

    protected static ?int $navigationSort = 81;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('uuid')->limit(12)->toggleable(),
                TextColumn::make('queue')->badge()->searchable(),
                TextColumn::make('payload')
                    ->label('Job')
                    ->formatStateUsing(function ($state) {
                        $payload = is_array($state) ? $state : (json_decode((string) $state, true) ?: []);
                        $display = $payload['displayName'] ?? $payload['job'] ?? 'Failed job';

                        return is_string($display) ? class_basename($display) : 'Failed job';
                    }),
                TextColumn::make('exception')->limit(80)->wrap()->toggleable(),
                TextColumn::make('failed_at')->since()->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageFailedJobs::route('/')];
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
