<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['password'] = '******';

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ('******' === $data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $record->fill($data);

        $record->email_verified_at = $data['email_verified_at'] ?? null;

        $record->save();

        return $record;
    }
}
