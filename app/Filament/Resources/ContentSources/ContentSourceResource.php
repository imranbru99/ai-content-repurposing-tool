<?php

namespace App\Filament\Resources\ContentSources;

use App\Filament\Resources\ContentSources\Pages\ManageContentSources;
use App\Models\ContentSource;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class ContentSourceResource extends Resource
{
    protected static ?string $model = ContentSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|UnitEnum|null $navigationGroup = 'Content Ops';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('source_ingest');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(200),
            Select::make('source_type')->options(config('repurpose.source_types'))->required()->default('blog'),
            Select::make('status')->options([
                'ingested' => 'Ingested',
                'processing' => 'Processing',
                'ready' => 'Ready',
                'archived' => 'Archived',
            ])->required()->default('ready'),
            TextInput::make('source_url')->url()->maxLength(255),
            TextInput::make('duration_minutes')->numeric(),
            TextInput::make('word_count')->numeric(),
            Select::make('brand_voice_id')->relationship('brandVoice', 'name')->searchable(),
            Select::make('owner_id')->relationship('owner', 'name')->searchable(),
            Textarea::make('summary')->columnSpanFull(),
            Textarea::make('original_body')->columnSpanFull()->rows(6),
            Textarea::make('cleaned_transcript')->columnSpanFull()->rows(6),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('source_type')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('word_count')->sortable(),
                TextColumn::make('brandVoice.name')->label('Voice')->toggleable(),
                TextColumn::make('ingested_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('source_type')->options(config('repurpose.source_types')),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageContentSources::route('/')];
    }
}
