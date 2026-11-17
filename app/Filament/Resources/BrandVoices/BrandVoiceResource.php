<?php

namespace App\Filament\Resources\BrandVoices;

use App\Filament\Resources\BrandVoices\Pages\ManageBrandVoices;
use App\Models\BrandVoice;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class BrandVoiceResource extends Resource
{
    protected static ?string $model = BrandVoice::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;
    protected static string|UnitEnum|null $navigationGroup = 'Brand & Channels';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('brand_voice');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(120),
            TextInput::make('persona')->maxLength(120),
            TextInput::make('tone')->required()->default('professional')->maxLength(60),
            Toggle::make('is_default')->default(false),
            Textarea::make('guidelines')->columnSpanFull()->rows(5),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('persona')->toggleable(),
                TextColumn::make('tone')->badge(),
                IconColumn::make('is_default')->boolean(),
                TextColumn::make('updated_at')->since(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageBrandVoices::route('/')];
    }
}
