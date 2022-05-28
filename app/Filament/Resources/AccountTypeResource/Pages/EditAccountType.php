<?php

namespace App\Filament\Resources\AccountTypeResource\Pages;

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
        $record->update($data);

        User::permission('account_types.add_accounts.'.$record->getKey())
            ->get()
            ->each
            ->revokePermissionTo('account_types.add_accounts.'.$record->getKey())
        ;

        if ($data['usable_user_logins']) {
            User::whereIn('login', $data['usable_user_logins'])
                ->get()
                ->each
                ->givePermissionTo('account_types.add_accounts.'.$record->getKey())
            ;
        }

        return $record;
    }
}
