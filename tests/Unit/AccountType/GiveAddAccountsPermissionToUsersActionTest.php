<?php

use App\Actions\AccountType\GiveAddAccountsPermissionToUsers;
use App\Models\AccountType;
use App\Models\User;

beforeEach(function (): void {
    $this->type = AccountType::factory()->create();
    $this->user = User::factory()->create();
    $this->users = User::factory(2)->create();
});

it('work correctly with model', function (): void {
    GiveAddAccountsPermissionToUsers::run($this->type, $this->user);

    expect($this->user->hasPermissionTo("account_types.add_accounts.{$this->type->getKey()}"))->toBeTrue();
});

it('work correctly with collection', function (): void {
    GiveAddAccountsPermissionToUsers::run($this->type, $this->users);

    expect($this->users[0]->hasPermissionTo("account_types.add_accounts.{$this->type->getKey()}"))->toBeTrue();
    expect($this->users[1]->hasPermissionTo("account_types.add_accounts.{$this->type->getKey()}"))->toBeTrue();
});
