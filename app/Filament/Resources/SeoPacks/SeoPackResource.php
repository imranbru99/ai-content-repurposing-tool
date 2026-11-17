<?php

namespace App\Filament\Resources\SeoPacks;

use App\Filament\Resources\SeoPacks\Pages\ManageSeoPacks;
use App\Models\ContentSource;
use App\Models\SeoPack;
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
use Filament\Tables\Table;
use UnitEnum;

class SeoPackResource extends Resource
{
    protected static ?string $model = SeoPack::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static string|UnitEnum|null $navigationGroup = 'Repurposing';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('seo_packs');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('primary_keyword')->required(),
            TextInput::make('meta_title')->maxLength(70),
            Textarea::make('meta_description')->columnSpanFull(),
            Select::make('content_source_id')->options(ContentSource::query()->pluck('title', 'id'))->searchable(),
            Select::make('created_by')->options(User::query()->pluck('name', 'id'))->searchable(),
            TextInput::make('search_intent')->maxLength(40),
            TextInput::make('difficulty_score')->numeric()->minValue(0)->maxValue(100),
            Select::make('status')->options(['draft' => 'Draft', 'ready' => 'Ready', 'published' => 'Published'])->default('ready'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('primary_keyword')->searchable()->sortable(),
                TextColumn::make('title')->limit(36),
                TextColumn::make('difficulty_score')->label('Difficulty')->sortable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('source.title')->label('Source')->toggleable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSeoPacks::route('/')];
    }
}