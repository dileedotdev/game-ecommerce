<?php

use App\Models\AccountField;
use App\Models\User;
use App\Policies\AccountFieldPolicy;

beforeEach(function (): void {
    $this->accountField = AccountField::factory()->create();
    $this->accountType = $this->accountField->type;
    $this->user = User::factory()->create();
    $this->policy = resolve(AccountFieldPolicy::class);
});

it('does not allow view any at all', function (): void {
    expect($this->policy->viewAny($this->user))->toBe(false);

    $this->user->givePermissionTo('account_types.view.*');
    $this->user->givePermissionTo('account_types.update.*');

    expect($this->policy->viewAny($this->user))->toBe(false);
});

it('allow view if user can view account type', function (): void {
    expect($this->policy->view($this->user, $this->accountField))->toBe(false);

    $this->user->givePermissionTo('account_types.view.*');

    expect($this->policy->view($this->user, $this->accountField))->toBe(true);
});

it('allow create if user can update account type', function (): void {
    expect($this->policy->create($this->user, $this->accountType))->toBe(false);

    $this->user->givePermissionTo('account_types.update.*');

    expect($this->policy->create($this->user, $this->accountType))->toBe(true);
});

it('allow update if user can update account type', function (): void {
    expect($this->policy->update($this->user, $this->accountField))->toBe(false);

    $this->user->givePermissionTo('account_types.update.*');

    expect($this->policy->update($this->user, $this->accountField))->toBe(true);
});

it('does not allow delete any at all', function (): void {
    expect($this->policy->deleteAny($this->user))->toBe(false);

    $this->user->givePermissionTo('account_types.update.*');
    $this->user->givePermissionTo('account_types.delete.*');
    $this->user->givePermissionTo('account_types.create.*');
    $this->user->givePermissionTo('account_types.view.*');

    expect($this->policy->deleteAny($this->user))->toBe(false);
});

it('allow delete if user can update account type', function (): void {
    expect($this->policy->delete($this->user, $this->accountField))->toBe(false);

    $this->user->givePermissionTo('account_types.update.*');

    expect($this->policy->delete($this->user, $this->accountField))->toBe(true);
});
