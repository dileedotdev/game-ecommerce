<?php

namespace App\Actions\Game;

use App\Models\Game;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class Create
{
    use AsAction;

    public function handle(string $name, string $publisherName, User $creator, ?string $description = null): Game
    {
        return Game::forceCreate([
            'name' => $name,
            'publisher_name' => $publisherName,
            'description' => $description,
            'creator_id' => $creator->id,
        ]);
    }
}
