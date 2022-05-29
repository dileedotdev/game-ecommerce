<?php

namespace App\Actions\AccountType;

use App\Models\AccountType;
use App\Models\Game;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class Create
{
    use AsAction;

    public function handle(Game $game, User $creator, string $name, ?string $description = null): AccountType
    {
        return AccountType::forceCreate([
            'game_id' => $game->id,
            'creator_id' => $creator->id,
            'name' => $name,
            'description' => $description,
        ]);
    }
}
