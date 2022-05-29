<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'publisher_name', 'description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'publisher_name' => $record->publisher_name,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(125),
                TextInput::make('publisher_name')
                    ->required()
                    ->maxLength(125),
                TextInput::make('description')
                    ->maxLength(255),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('publisher_name')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit()
                    ->searchable(),
                TextColumn::make('creator.login')
                    ->label('Creator'),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AccountTypesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'view' => Pages\ViewGame::route('/{record}'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
