<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Actions\Account\Create;
use App\Filament\Resources\AccountResource;
use App\Models\Account;
use App\Models\AccountType;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CreateAccount extends CreateRecord
{
    use HasWizard;

    protected static string $resource = AccountResource::class;

    protected function getUsableTypes(): Collection
    {
        return AccountType::all()
            ->filter(fn (AccountType $type) => Filament::auth()->user()->can('create', [Account::class, $type]))
        ;
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Basic Info')
                ->schema([
                    Select::make('account_type_id')
                        ->label('Account Type')
                        ->options(fn () => $this->getUsableTypes()->mapWithKeys(fn (AccountType $type) => [$type->id => "{$type->name} ({$type->game->name})"]))
                        ->searchable()
                        ->required(),
                    TextInput::make('description')
                        ->label('Description (public)')
                        ->maxLength(255),
                ]),
            Step::make('Details')
                ->description('Add some extra details')
                ->schema(function ($state, callable $set) {
                    if (!$state['account_type_id']) {
                        return [];
                    }

                    $fields = AccountType::find($state['account_type_id'])->fields;

                    $inputs = [];
                    foreach ($fields as $field) {
                        $inputs[] = TextInput::make("infos.{$field->getKey()}")
                            ->label($field->name)
                            ->regex($field->regex)
                            ->required($field->is_required)
                        ;
                    }

                    return $inputs;
                }),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return Create::run(
            accountType: AccountType::findOrFail($data['account_type_id']),
            creator: Filament::auth()->user(),
            description: $data['description'],
            infos: $data['infos'],
        );
    }
}
