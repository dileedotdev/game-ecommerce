<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Actions\Game\Delete;
use App\Filament\Resources\GameResource;
use App\Models\Game;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function handleRecordBulkDeletion(Collection $records): void
    {
        $records->each(function (Game $game): void {
            Delete::run($game);
        });
    }
}
