<?php

namespace App\Filament\Resources\ChannelDrafts;

use App\Enums\ChannelType;
use App\Enums\DraftStatus;
use App\Filament\Resources\ChannelDrafts\Pages\ManageChannelDrafts;
use App\Models\BrandVoice;
use App\Models\ChannelDraft;
use App\Models\ContentSource;
use App\Models\User;
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

class ChannelDraftResource extends Resource
{
    protected static ?string $model = ChannelDraft::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static string|UnitEnum|null $navigationGroup = 'Repurposing';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('multi_channel_drafts');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('content_source_id')->label('Source')->options(ContentSource::query()->pluck('title', 'id'))->required()->searchable(),
            Select::make('brand_voice_id')->options(BrandVoice::query()->pluck('name', 'id'))->searchable(),
            Select::make('author_id')->options(User::query()->pluck('name', 'id'))->searchable(),
            Select::make('channel')->options(collect(ChannelType::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))->required(),
            TextInput::make('title')->required()->maxLength(200),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Textarea::make('hook')->columnSpanFull(),
            Textarea::make('body')->columnSpanFull(),
            TextInput::make('cta')->maxLength(160),
            Select::make('status')->options(collect(DraftStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))->required(),
            TextInput::make('ai_score')->numeric()->step(0.01),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->limit(36)->searchable(),
                TextColumn::make('channel')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('source.title')->label('Source')->limit(24)->toggleable(),
                TextColumn::make('ai_score')->label('AI')->sortable(),
                TextColumn::make('scheduled_for')->since()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('channel')->options(collect(ChannelType::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                SelectFilter::make('status')->options(collect(DraftStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageChannelDrafts::route('/')];
    }
}