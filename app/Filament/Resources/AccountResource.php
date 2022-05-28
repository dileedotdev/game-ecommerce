<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use App\Models\AccountType;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationGroup = 'Accounts';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return AccountType::all()->some(fn (AccountType $type) => Filament::auth()->user()->can('create', [Account::class, $type]));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Textarea::make('description')
                            ->maxLength(255),
                    ])
                    ->columnSpan(1),

                Card::make()
                    ->schema([
                        Placeholder::make('account_type_name')
                            ->label('Account Type')
                            ->content(fn (?Account $record): string => $record ? $record->type->name : '--'),
                        Placeholder::make('game_name')
                            ->label('Game')
                            ->content(fn (?Account $record): string => $record ? $record->type->game->name : '--'),
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (?Account $record): string => $record ? $record->created_at->diffForHumans() : '--'),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (?Account $record): string => $record ? $record->updated_at->diffForHumans() : '--'),
                        Placeholder::make('creator_login')
                            ->label('Creator')
                            ->content(fn (?Account $record): string => $record ? $record->creator->login : '--'),
                        Placeholder::make('buyer_login')
                            ->label('Buyer')
                            ->content(fn (?Account $record): string => $record ? $record->buyer?->login ?? '--' : '--'),
                        Placeholder::make('confirmed_at')
                            ->content(fn (?Account $record): string => $record ? $record->confirmed_at?->diffForHumans() ?? '--' : '--'),
                    ])
                    ->columns(2)
                    ->columnSpan([
                        'lg' => 2,
                    ]),
            ])
            ->columns(3)
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type.game.name')
                    ->label('Game'),
                TextColumn::make('type.name')
                    ->label('Account Type'),
                TextColumn::make('creator.login')
                    ->label('Creator'),
                TextColumn::make('buyer.login')
                    ->label('Buyer'),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('confirmed_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('Confirmed')
                    ->toggle()
                    ->query(fn (Builder $builder) => $builder->whereNotNull('confirmed_at')),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\InfosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
