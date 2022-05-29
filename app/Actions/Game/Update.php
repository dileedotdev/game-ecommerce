<?php

namespace App\Actions\Game;

use App\Models\Game;
use Lorisleiva\Actions\Concerns\AsAction;

class Update
{
    use AsAction;

    public function handle(Game $game, string $name, string $publisherName, ?string $description = null): void
    {
        $result = $game->forceFill([
            'name' => $name,
            'publisher_name' => $publisherName,
            'description' => $description,
        ])->save();

        if (!$result) {
            throw new \Exception('Cannot update game');
        }
    }
}
