<?php

use App\Models\AccountType;
use App\Models\Permission;
use App\Models\User;
use App\Policies\AccountTypePolicy;

beforeEach(function (): void {
    $this->accountType = AccountType::factory()->create();
    $this->user = User::factory()->create();
    $this->policy = resolve(AccountTypePolicy::class);
});

it('allow view any if user has account_types.view.* permission', function (): void {
    $permissions = Permission::findOrCreate('account_types.view.*');

    expect($this->policy->viewAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->viewAny($this->user))->toBe(true);
});

it('allow view if user has account_types.view.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('account_types.view.'.$this->accountType->getKey());

    expect($this->policy->view($this->user, $this->accountType))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->view($this->user, $this->accountType))->toBe(true);
});

it('allow create if user has account_types.create permission', function (): void {
    $permissions = Permission::findOrCreate('account_types.create');

    expect($this->policy->create($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->create($this->user))->toBe(true);
});

it('allow update if user has account_types.update.{key} permission', function (): void {
    $permissions = Permission::findOrCreate('account_types.update.'.$this->accountType->getKey());

    expect($this->policy->update($this->user, $this->accountType))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->update($this->user, $this->accountType))->toBe(true);
});

it('deny delete any at all', function (): void {
    $permissions = Permission::findOrCreate('account_types.delete.*');

    expect($this->policy->deleteAny($this->user))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->deleteAny($this->user))->toBe(false);
});

it('deny delete at all', function (): void {
    $permissions = Permission::findOrCreate('account_types.delete.'.$this->accountType->getKey());

    expect($this->policy->delete($this->user, $this->accountType))->toBe(false);

    $this->user->givePermissionTo($permissions);

    expect($this->policy->delete($this->user, $this->accountType))->toBe(false);
});
