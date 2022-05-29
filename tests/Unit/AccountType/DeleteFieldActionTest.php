<?php

use App\Actions\AccountType\DeleteField;
use App\Models\AccountField;
use App\Models\AccountInfo;

beforeEach(function (): void {
    $this->field = AccountField::factory()->create();
});

it('should delete correctly', function (): void {
    DeleteField::run($this->field);

    expect($this->field->exists())->toBeFalse();
});

it('also delete related infos', function (): void {
    $info = AccountInfo::factory()->create([
        'account_field_id' => $this->field->id,
    ]);

    DeleteField::run($this->field);

    expect($info->exists())->toBeFalse();
});
