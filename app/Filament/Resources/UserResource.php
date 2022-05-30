<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'login';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return '@'.$record->login;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'login', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'name' => $record->name,
            'email' => $record->email,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('login')
                    ->required()
                    ->maxLength(125),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                    ->nullable(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('login')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('formatted_balance')
                    ->label('Balance'),
                TextColumn::make('email_verified_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('Verified')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ])
            ->pushActions([
                Action::make('balance')
                    ->label('Update balance')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn (User $record): bool => Filament::auth()->user()->can('updateBalance', $record))
                    ->form([
                        Radio::make('type')
                            ->required()
                            ->options([
                                'increase' => 'Increase',
                                'decrease' => 'Decrease',
                            ]),
                        TextInput::make('amount')
                            ->integer()
                            ->required(),
                        TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->action(function (User $record, array $data): void {
                        if ('increase' === $data['type']) {
                            $record->deposit($data['amount'], [
                                'description' => $data['description'],
                            ]);
                        } else {
                            $record->withdraw($data['amount'], [
                                'description' => $data['description'],
                            ]);
                        }
                    }),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
            RelationManagers\PermissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\RegisteringOverview::class,
        ];
    }
}
