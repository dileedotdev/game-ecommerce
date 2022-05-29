<?php

use App\Actions\Account\DeleteInfo;
use App\Models\AccountInfo;

beforeEach(function (): void {
    $this->info = AccountInfo::factory()->create();
});

it('should delete account info', function (): void {
    DeleteInfo::run($this->info);

    expect($this->info->exists())->toBe(false);
});
