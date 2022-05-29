<?php

use App\Actions\Game\Update;
use App\Models\Game;

beforeEach(function (): void {
    $this->game = Game::factory()->create();
});

it('should update game', function (): void {
    Update::run(
        game: $this->game,
        name: 'new Name',
        publisherName: 'new Publisher',
        description: 'new Description'
    );

    expect($this->game->name)->toBe('new Name');
    expect($this->game->publisher_name)->toBe('new Publisher');
    expect($this->game->description)->toBe('new Description');
});
