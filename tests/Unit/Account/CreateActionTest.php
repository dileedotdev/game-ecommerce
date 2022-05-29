<?php

use App\Actions\Account\Create;
use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountType;
use App\Models\User;

beforeEach(function (): void {
    $this->type = AccountType::factory()->has(AccountField::factory(2), 'fields')->create();
    $this->user = User::factory()->create();
});

it('should create account with infos', function (): void {
    $account = Create::run(
        accountType: $this->type,
        creator: $this->user,
        description: 'this is description',
        infos: [
            $this->type->fields[0]->id => 'value1',
            $this->type->fields[1]->id => 'value2',
        ]
    );

    expect($account)->toBeInstanceOf(Account::class);
    expect($account->exists())->toBe(true);
    expect($account->account_type_id)->toBe($this->type->id);
    expect($account->description)->toBe('this is description');
    expect($account->infos[0]->value)->toBe('value1');
    expect($account->infos[1]->value)->toBe('value2');
});
