<?php

use App\Models\Game;
use App\Models\Permission;
use App\Models\User;
use App\Policies\GamePolicy;

beforeEach(function (): void {
    $this->game = Game::factory()->create();
    $this->user = User::factory()->create();
    $this->policy = resolve(GamePolicy::class);
});

it('allow view any if user has games.view.* permission', function (): void {
    $permissions = Permission::findOrCreate('games.view.*');

    expect($this->policy->viewAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->viewAny($this->user))->toBe(true);
});

it('allow view if user has games.view.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('games.view.'.$this->game->getKey());

    expect($this->policy->view($this->user, $this->game))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->view($this->user, $this->game))->toBe(true);
});

it('allow create if user has games.create permission', function (): void {
    $permissions = Permission::findOrCreate('games.create');

    expect($this->policy->create($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->create($this->user))->toBe(true);
});

it('allow update if user has games.update.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('games.update.'.$this->game->getKey());

    expect($this->policy->update($this->user, $this->game))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->update($this->user, $this->game))->toBe(true);
});

it('deny delete any at all', function (): void {
    $permissions = Permission::findOrCreate('games.delete.*');

    expect($this->policy->deleteAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->deleteAny($this->user))->toBe(false);
});

it('deny delete at all', function (): void {
    $permissions = Permission::findOrCreate('games.delete.'.$this->game->getKey());

    expect($this->policy->delete($this->user, $this->game))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->delete($this->user, $this->game))->toBe(false);
});
