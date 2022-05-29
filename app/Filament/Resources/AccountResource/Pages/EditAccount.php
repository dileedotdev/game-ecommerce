<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Actions\Account\Delete;
use App\Actions\Account\Update;
use App\Filament\Resources\AccountResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Update::run(
            account: $record,
            description: $data['description'],
        );

        return $record;
    }

    protected function beforeDelete(): void
    {
        Delete::run($this->record);
    }
}
