<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Actions\Game\Create;
use App\Filament\Resources\GameResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGame extends CreateRecord
{
    protected static string $resource = GameResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return Create::run(
            name: $data['name'],
            publisherName: $data['publisher_name'],
            creator: Filament::auth()->user(),
            description: $data['description']
        );
    }
}
