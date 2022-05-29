<?php

use App\Actions\AccountType\Update;
use App\Models\AccountType;

beforeEach(function (): void {
    $this->type = AccountType::factory()->create();
});

it('should update correctly', function (): void {
    Update::run(
        accountType: $this->type,
        name: 'New Name',
        description: 'New Description',
    );

    expect($this->type->name)->toBe('New Name');
    expect($this->type->description)->toBe('New Description');
});
