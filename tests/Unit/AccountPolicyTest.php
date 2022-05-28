<?php

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Permission;
use App\Models\User;
use App\Policies\AccountPolicy;

beforeEach(function (): void {
    $this->account = Account::factory()->create();
    $this->user = User::factory()->create();
    $this->policy = resolve(AccountPolicy::class);
});

it('allow view any if user has accounts.view.* permission', function (): void {
    $permissions = Permission::findOrCreate('accounts.view.*');

    expect($this->policy->viewAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->viewAny($this->user))->toBe(true);
});

it('allow view if user has accounts.view.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('accounts.view.'.$this->account->getKey());

    expect($this->policy->view($this->user, $this->account))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->view($this->user, $this->account))->toBe(true);
});

it('allow create if user has account_types.add_accounts.{account_type_key} permission', function (): void {
    $accountType = AccountType::factory()->create();
    $permissions = Permission::findOrCreate('account_types.add_accounts.'.$accountType->getKey());

    expect($this->policy->create($this->user, $accountType))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->create($this->user, $accountType))->toBe(true);
});

it('allow update if user has accounts.update.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('accounts.update.'.$this->account->getKey());

    expect($this->policy->update($this->user, $this->account))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->update($this->user, $this->account))->toBe(true);
});

it('allow delete any if user has accounts.delete.* permission', function (): void {
    $permissions = Permission::findOrCreate('accounts.delete.*');

    expect($this->policy->deleteAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->deleteAny($this->user))->toBe(true);
});

it('allow delete if user has accounts.delete.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('accounts.delete.'.$this->account->getKey());

    expect($this->policy->delete($this->user, $this->account))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->delete($this->user, $this->account))->toBe(true);
});
