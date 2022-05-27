<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('games.view.*');
    }

    public function view(User $user, Game $game): bool
    {
        return $user->hasPermissionTo('games.view.'.$game->getKey());
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('games.create');
    }

    public function update(User $user, Game $game): bool
    {
        return $user->hasPermissionTo('games.update.'.$game->getKey());
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('games.delete.*');
    }

    public function delete(User $user, Game $game): bool
    {
        return $user->hasPermissionTo('games.delete.'.$game->getKey());
    }
}
