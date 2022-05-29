<?php

use App\Actions\Account\CreateInfo;
use App\Actions\Account\Delete;
use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountType;

beforeEach(function (): void {
    $this->account = Account::factory()->create([
        'account_type_id' => AccountType::factory()->has(AccountField::factory(2), 'fields'),
    ]);

    CreateInfo::run(
        account: $this->account,
        accountField: $this->account->type->fields[0],
        value: 'test'
    );
});

it('should delete account', function (): void {
    Delete::run($this->account);

    expect($this->account->exists())->toBe(false);
});

it('also delete related infos', function (): void {
    expect($this->account->infos()->count())->toBe(1);

    Delete::run($this->account);

    expect($this->account->infos()->count())->toBe(0);
});
