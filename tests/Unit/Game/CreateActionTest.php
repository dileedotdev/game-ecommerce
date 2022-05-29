<?php

use App\Actions\Game\Create;
use App\Models\Game;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

it('should create game', function (): void {
    $game = Create::run(
        creator: $this->user,
        publisherName: 'riot test',
        name: 'test name',
        description: 'test description',
    );

    expect($game)->toBeInstanceOf(Game::class);
    expect($game->exists())->toBe(true);
    expect($game->name)->toBe('test name');
    expect($game->publisher_name)->toBe('riot test');
    expect($game->description)->toBe('test description');
    expect($game->creator_id)->toBe($this->user->id);
});
