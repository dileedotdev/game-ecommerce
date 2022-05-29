<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Actions\Game\Update;
use App\Filament\Resources\GameResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditGame extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Update::run($record,
            name: $data['name'],
            publisherName: $data['publisher_name'],
            description: $data['description'],
        );

        return $record;
    }
}
