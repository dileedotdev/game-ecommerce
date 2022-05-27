<?php

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use App\Models\AccountType;
use App\Models\User;
use App\Policies\AccountInfoPolicy;

beforeEach(function (): void {
    $this->accountInfo = AccountInfo::factory()
        ->for(Account::factory()->for(AccountType::factory()->has(AccountField::factory(), 'fields'), 'type'))
        ->create()
    ;
    $this->account = $this->accountInfo->account;
    $this->accountType = $this->account->type;
    $this->user = User::factory()->create();
    $this->policy = resolve(AccountInfoPolicy::class);
});

it('does not allow view any at all', function (): void {
    expect($this->policy->viewAny($this->user))->toBe(false);

    $this->user->givePermissionTo('accounts.view.*');
    $this->user->givePermissionTo('accounts.update.*');
    $this->user->givePermissionTo('accounts.delete.*');

    expect($this->policy->viewAny($this->user))->toBe(false);
});

it('allow anyon view if it field allowed', function (): void {
    $this->accountInfo->field->can_view_by_anyone = false;
    expect($this->policy->view($this->user, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_view_by_anyone = true;
    expect($this->policy->view($this->user, $this->accountInfo))->toBe(true);
});

it('allow creator view if it has accounts.view.{key} permission and field allow create view', function (): void {
    $creator = $this->accountInfo->account->creator;
    $this->accountInfo->field->can_view_by_anyone = false;

    $this->accountInfo->field->can_view_by_creator = false;
    expect($this->policy->view($creator, $this->accountInfo))->toBe(false);

    $creator->givePermissionTo('accounts.view.*');
    expect($this->policy->view($creator, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_view_by_creator = true;
    expect($this->policy->view($creator, $this->accountInfo))->toBe(true);
});

it('allow unconfirmed buyer view if it has accounts.view.{key} permission and field allowed', function (): void {
    $buyer = User::factory()->create();
    $this->accountInfo->account->buyer_id = $buyer->id;
    $this->accountInfo->account->confirmed_at = null;
    $this->accountInfo->field->can_view_by_anyone = false;

    $this->accountInfo->field->can_view_by_unconfirmed_buyer = false;
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(false);

    $buyer->givePermissionTo('accounts.view.*');
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_view_by_unconfirmed_buyer = true;
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(true);
});

it('allow confirmed buyer view if it has accounts.view.{key} permission and field allowed', function (): void {
    $buyer = User::factory()->create();
    $this->accountInfo->account->buyer_id = $buyer->id;
    $this->accountInfo->account->confirmed_at = now();
    $this->accountInfo->field->can_view_by_anyone = false;

    $this->accountInfo->field->can_view_by_confirmed_buyer = false;
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(false);

    $buyer->givePermissionTo('accounts.view.*');
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_view_by_confirmed_buyer = true;
    expect($this->policy->view($buyer, $this->accountInfo))->toBe(true);
});

it('allow administrator view if it has accounts.view.{key} permission', function (): void {
    $admin = User::factory()->create();
    $this->accountInfo->field->can_view_by_anyone = false;
    expect($this->policy->view($admin, $this->accountInfo))->toBe(false);

    $admin->givePermissionTo('accounts.view.*');
    expect($this->policy->view($admin, $this->accountInfo))->toBe(true);
});

it('not allow create if account type is diff with other', function (): void {
    $this->user->givePermissionTo('accounts.update.*');

    expect($this->policy->create($this->user, $this->account, $this->accountType->fields[0]))->toBe(true);
    expect($this->policy->create($this->user, $this->account, AccountField::factory()->create()))->toBe(false);
});

it('allow creator create if creator has accounts.update.{key} permission and field allowed', function (): void {
    $creator = $this->account->creator;
    $this->accountType->fields[0]->can_create_by_creator = false;
    expect($this->policy->create($creator, $this->account, $this->accountType->fields[0]))->toBe(false);

    $creator->givePermissionTo('accounts.update.*');
    expect($this->policy->create($creator, $this->account, $this->accountType->fields[0]))->toBe(false);

    $this->accountType->fields[0]->can_create_by_creator = true;
    expect($this->policy->create($creator, $this->account, $this->accountType->fields[0]))->toBe(true);
});

it('allow admin create if admin has accounts.update.{key} permission', function (): void {
    $admin = User::factory()->create();
    expect($this->policy->create($admin, $this->account, $this->accountType->fields[0]))->toBe(false);

    $admin->givePermissionTo('accounts.update.*');
    expect($this->policy->create($admin, $this->account, $this->accountType->fields[0]))->toBe(true);
});

it('allow creator update if creator has accounts.update.{key} permission and field allowed', function (): void {
    $creator = $this->account->creator;
    $this->accountInfo->field->can_update_by_creator = false;
    expect($this->policy->update($creator, $this->accountInfo))->toBe(false);

    $creator->givePermissionTo('accounts.update.*');
    expect($this->policy->update($creator, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_update_by_creator = true;
    expect($this->policy->update($creator, $this->accountInfo))->toBe(true);
});

it('allow admin update if admin has accounts.update.{key} permission', function (): void {
    $admin = User::factory()->create();
    expect($this->policy->update($admin, $this->accountInfo))->toBe(false);

    $admin->givePermissionTo('accounts.update.*');
    expect($this->policy->update($admin, $this->accountInfo))->toBe(true);
});

it('does not allow delete any at all', function (): void {
    expect($this->policy->deleteAny($this->user))->toBe(false);

    $this->user->givePermissionTo('accounts.update.*');
    $this->user->givePermissionTo('accounts.delete.*');
    $this->user->givePermissionTo('accounts.create.*');
    $this->user->givePermissionTo('accounts.view.*');

    expect($this->policy->deleteAny($this->user))->toBe(false);
});

it('allow creator delete if creator has accounts.update.{key} permission and field allowed', function (): void {
    $creator = $this->account->creator;
    $this->accountInfo->field->can_delete_by_creator = false;
    expect($this->policy->delete($creator, $this->accountInfo))->toBe(false);

    $creator->givePermissionTo('accounts.update.*');
    expect($this->policy->delete($creator, $this->accountInfo))->toBe(false);

    $this->accountInfo->field->can_delete_by_creator = true;
    expect($this->policy->delete($creator, $this->accountInfo))->toBe(true);
});

it('allow admin delete if admin has accounts.update.{key} permission', function (): void {
    $admin = User::factory()->create();
    expect($this->policy->delete($admin, $this->accountInfo))->toBe(false);

    $admin->givePermissionTo('accounts.update.*');
    expect($this->policy->delete($admin, $this->accountInfo))->toBe(true);
});
