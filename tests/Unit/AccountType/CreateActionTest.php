<?php

use App\Actions\AccountType\Create;
use App\Models\AccountType;
use App\Models\Game;
use App\Models\User;

beforeEach(function (): void {
    $this->game = Game::factory()->create();
    $this->user = User::factory()->create();
});

it('should create correctly', function (): void {
    $type = Create::run(
        game: $this->game,
        creator: $this->user,
        name: 'New Game 2022',
        description: 'This is a new game',
    );

    expect($type)->toBeInstanceOf(AccountType::class);
    expect($type->exists())->toBeTrue();

    expect($type->game_id)->toBe($this->game->id);
    expect($type->creator_id)->toBe($this->user->id);
    expect($type->name)->toBe('New Game 2022');
    expect($type->description)->toBe('This is a new game');
});
