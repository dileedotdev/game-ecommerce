<?php

namespace App\Filament\Resources\AccountTypeResource\Pages;

use App\Filament\Resources\AccountTypeResource;
use App\Models\AccountType;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAccountType extends CreateRecord
{
    protected static string $resource = AccountTypeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $type = AccountType::create($data);

        dd($data['usable_user_ids']);
        if ($data['usable_user_ids']) {
            User::whereIn('id', $data['usable_user_ids'])->each->attachPermissionTo('accounts.create.'.$type->getKey());
        }

        return $type;
    }
}
