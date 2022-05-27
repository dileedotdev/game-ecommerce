<?php

namespace App\Filament\Resources\AccountTypeResource\RelationManagers;

use App\Models\AccountField;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FieldsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'fields';

    protected static ?string $recordTitleAttribute = 'name';

    protected function getRelationship(): Relation|Builder
    {
        return $this->ownerRecord->{static::getRelationshipName()}()->with('type');
    }

    protected function canCreate(): bool
    {
        return Filament::auth()->user()->can('create', [AccountField::class, $this->ownerRecord]);
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(125),
                TextInput::make('regex')
                    ->regex('/^\/.*\/[a-z]*$/')
                    ->maxLength(255),
                Toggle::make('is_required')
                    ->label('Required')
                    ->required(),
                Toggle::make('can_create_by_creator')
                    ->required(),
                Toggle::make('can_update_by_creator')
                    ->required(),
                Toggle::make('can_delete_by_creator')
                    ->required(),
                Toggle::make('can_view_by_anyone')
                    ->required(),
                Toggle::make('can_view_by_creator')
                    ->required(),
                Toggle::make('can_view_by_unconfirmed_buyer')
                    ->required(),
                Toggle::make('can_view_by_confirmed_buyer')
                    ->required(),
            ])
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('regex')
                    ->searchable(),
                BooleanColumn::make('is_required')
                    ->label('Required'),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('can_create_by_creator')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_create_by_creator', true)),
                Filter::make('can_update_by_creator')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_update_by_creator', true)),
                Filter::make('can_delete_by_creator')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_delete_by_creator', true)),
                Filter::make('can_view_by_anyone')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_view_by_anyone', true)),
                Filter::make('can_view_by_creator')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_view_by_creator', true)),
                Filter::make('can_view_by_unconfirmed_buyer')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_view_by_unconfirmed_buyer', true)),
                Filter::make('can_view_by_confirmed_buyer')
                    ->toggle()
                    ->query(fn (Builder $builder): Builder => $builder->where('can_view_by_confirmed_buyer', true)),
            ])
        ;
    }
}
