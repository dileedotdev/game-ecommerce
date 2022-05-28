<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use App\Models\AccountField;
use App\Models\AccountInfo;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

class InfosRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'infos';

    protected static ?string $recordTitleAttribute = 'value';

    protected function getRelationship(): Relation|Builder
    {
        return $this->ownerRecord->{static::getRelationshipName()}()->with('account');
    }

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return true;
    }

    protected function canCreate(): bool
    {
        return !$this->getUsableFields()->isEmpty();
    }

    protected function getUsableFields(): Collection
    {
        $account = $this->ownerRecord;

        $excluded = $account->fields->pluck('id')->toArray();

        return AccountField::whereAccountTypeId($account->account_type_id)
            ->whereNotIn('id', $excluded)
            ->get()
            ->filter(fn (AccountField $field) => Filament::auth()->user()->can('create', [AccountInfo::class, $account, $field]))
        ;
    }

    protected function getCreateFormSchema(): array
    {
        return [
            Select::make('account_field_id')
                ->label('Field')
                ->searchable()
                ->reactive()
                ->options(fn () => $this->getUsableFields()->pluck('name', 'id')),
            TextInput::make('value')
                ->regex(fn (callable $get) => $get('account_field_id') ? AccountField::find($get('account_field_id'))->regex : null)
                ->required(fn (callable $get) => $get('account_field_id') ? AccountField::find($get('account_field_id'))->is_required : false),
        ];
    }

    protected function getEditFormSchema(): array
    {
        return [
            TextInput::make('value')
                ->regex(fn (AccountInfo $record) => $record->field->regex)
                ->required(fn (AccountInfo $record) => $record->field->is_required),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field.name')
                    ->label('name'),
                TextColumn::make('masked_value')
                    ->label('value'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
            ])
        ;
    }
}
