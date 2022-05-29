<?php

use App\Actions\Account\CreateInfo;
use App\Actions\Account\Update;
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

it('should update account', function (): void {
    Update::run(
        account: $this->account,
        description: 'xin chao cac ban',
    );

    expect($this->account->description)->toBe('xin chao cac ban');
    expect($this->account->infos()->count(1));
});

it('should update account and its infos', function (): void {
    Update::run(
        account: $this->account,
        description: 'xin chao cac ban',
        infos: [
            $this->account->type->fields[0]->getKey() => 'test2',
            $this->account->type->fields[1]->getKey() => 'test3',
        ]
    );

    $this->account->load('infos');

    expect($this->account->infos()->count(2));
    expect($this->account->infos[0]->value)->toBe('test2');
    expect($this->account->infos[1]->value)->toBe('test3');
});
