<?php

use App\Actions\AccountType\GiveAddAccountsPermissionToUsers;
use App\Actions\AccountType\RevokeAddAccountsPermissionInAllUsers;
use App\Models\AccountType;
use App\Models\User;

beforeEach(function (): void {
    $this->type = AccountType::factory()->create();
    $this->users = User::factory(2)->create();
    GiveAddAccountsPermissionToUsers::run($this->type, $this->users);

    unset($this->users[0]->permissions, $this->users[1]->permissions);
});

it('work correctly with model', function (): void {
    RevokeAddAccountsPermissionInAllUsers::run($this->type);

    expect($this->users[1]->hasPermissionTo("account_types.add_accounts.{$this->type->getKey()}"))->toBeFalse();
    expect($this->users[0]->hasPermissionTo("account_types.add_accounts.{$this->type->getKey()}"))->toBeFalse();
});
