<?php

use App\Actions\Account\CreateInfo;
use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use App\Models\AccountType;

beforeEach(function (): void {
    $this->account = Account::factory()->create([
        'account_type_id' => AccountType::factory()->has(AccountField::factory(2), 'fields'),
    ]);
});

it('should create account info', function (): void {
    $info = CreateInfo::run(
        account: $this->account,
        accountField: $this->account->type->fields[0],
        value: 'test'
    );

    expect($info)->toBeInstanceOf(AccountInfo::class);
    expect($info->exists())->toBe(true);
    expect($info->account_id)->toBe($this->account->id);
    expect($info->account_field_id)->toBe($this->account->type->fields[0]->id);
    expect($info->value)->toBe('test');
});
