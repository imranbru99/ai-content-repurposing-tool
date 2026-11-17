<?php

namespace App\Filament\Resources\CalendarItems;

use App\Enums\ChannelType;
use App\Enums\DraftStatus;
use App\Filament\Resources\CalendarItems\Pages\ManageCalendarItems;
use App\Models\CalendarItem;
use App\Models\ChannelDraft;
use App\Models\ContentSource;
use App\Models\User;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CalendarItemResource extends Resource
{
    protected static ?string $model = CalendarItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Repurposing';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('content_calendar');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(200),
            Select::make('channel')->options(collect(ChannelType::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))->required(),
            Select::make('status')->options(collect(DraftStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))->required(),
            DateTimePicker::make('scheduled_at')->required(),
            TextInput::make('timezone')->default('UTC'),
            Select::make('content_source_id')->options(ContentSource::query()->pluck('title', 'id'))->searchable(),
            Select::make('channel_draft_id')->options(ChannelDraft::query()->pluck('title', 'id'))->searchable(),
            Select::make('owner_id')->options(User::query()->pluck('name', 'id'))->searchable(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')->dateTime()->sortable(),
                TextColumn::make('title')->limit(40)->searchable(),
                TextColumn::make('channel')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('owner.name')->toggleable(),
            ])
            ->defaultSort('scheduled_at')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageCalendarItems::route('/')];
    }
}