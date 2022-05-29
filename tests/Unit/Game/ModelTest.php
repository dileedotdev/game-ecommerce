<?php

use App\Models\Game;
use App\Models\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

it('create related permission and give to creator on creating', function (): void {
    $game = Game::factory()->create();

    expect(Permission::findByName('games.view.'.$game->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('games.update.'.$game->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('games.delete.'.$game->getKey()))->toBeInstanceOf(Permission::class);

    expect($game->creator->hasPermissionTo('games.view.'.$game->getKey()))->toBeTrue();
    expect($game->creator->hasPermissionTo('games.update.'.$game->getKey()))->toBeTrue();
    expect($game->creator->hasPermissionTo('games.delete.'.$game->getKey()))->toBeTrue();
});

it('delete related permission on deleting', function (): void {
    $game = Game::factory()->create();
    $game->delete();

    $game->creator->load('permissions');

    expect($game->creator->hasPermissionTo('games.view.'.$game->getKey()))->toBeFalse();
    expect($game->creator->hasPermissionTo('games.update.'.$game->getKey()))->toBeFalse();
    expect($game->creator->hasPermissionTo('games.delete.'.$game->getKey()))->toBeFalse();

    Permission::findByName('games.view.'.$game->getKey());
})->throws(PermissionDoesNotExist::class);
