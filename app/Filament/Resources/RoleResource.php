<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationGroup = 'Authentication';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'guard_name', 'description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'guard' => $record->guard_name,
            'description' => $record->description,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->minLength(6)
                    ->maxLength(125)
                    ->searchable(),
                TextInput::make('guard_name')
                    ->required()
                    ->default(config('auth.defaults.guard'))
                    ->maxLength(125)
                    ->searchable(),
                TextInput::make('description')
                    ->nullable()
                    ->maxLength(255)
                    ->searchable(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('guard_name'),
                BooleanColumn::make('is_build_in')->label('Build In'),
                TextColumn::make('description')->limit(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('Build In')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_build_in', true)),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
