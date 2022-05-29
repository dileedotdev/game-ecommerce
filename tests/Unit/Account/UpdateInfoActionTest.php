<?php

use App\Actions\Account\UpdateInfo;
use App\Models\AccountInfo;

beforeEach(function (): void {
    $this->info = AccountInfo::factory()->create();
});

it('should update info', function (): void {
    UpdateInfo::run($this->info, 'test xxx');

    expect($this->info->value)->toBe('test xxx');
});
