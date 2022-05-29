<?php

namespace App\Filament\Resources\AccountTypeResource\Pages;

use App\Actions\AccountType\GiveAddAccountsPermissionToUser;
use App\Actions\AccountType\RevokeAddAccountsPermissionInAllUsers;
use App\Actions\AccountType\Update;
use App\Filament\Resources\AccountTypeResource;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAccountType extends EditRecord
{
    protected static string $resource = AccountTypeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['usable_user_logins'] = User::permission('account_types.add_accounts.'.$this->record->getKey())
            ->get()
            ->pluck('login')
            ->toArray()
        ;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Update::run($record,
            name: $data['name'],
            description: $data['description'],
        );

        RevokeAddAccountsPermissionInAllUsers::run($record);

        if ($data['usable_user_logins']) {
            GiveAddAccountsPermissionToUser::run($record, users: User::whereIn('login', $data['usable_user_logins'])->get());
        }

        return $record;
    }
}
