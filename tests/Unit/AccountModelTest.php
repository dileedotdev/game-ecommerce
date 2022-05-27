<?php

use App\Models\Account;
use App\Models\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

it('create related permission and give to creator on creating', function (): void {
    $account = Account::factory()->create();

    expect(Permission::findByName('accounts.view.'.$account->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('accounts.update.'.$account->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('accounts.delete.'.$account->getKey()))->toBeInstanceOf(Permission::class);

    expect($account->creator->hasPermissionTo('accounts.view.'.$account->getKey()))->toBeTrue();
    expect($account->creator->hasPermissionTo('accounts.update.'.$account->getKey()))->toBeTrue();
    expect($account->creator->hasPermissionTo('accounts.delete.'.$account->getKey()))->toBeTrue();
});

it('delete related permission on deleting', function (): void {
    $account = Account::factory()->create();
    $account->delete();

    $account->creator->load('permissions');

    expect($account->creator->hasPermissionTo('accounts.view.'.$account->getKey()))->toBeFalse();
    expect($account->creator->hasPermissionTo('accounts.update.'.$account->getKey()))->toBeFalse();
    expect($account->creator->hasPermissionTo('accounts.delete.'.$account->getKey()))->toBeFalse();

    Permission::findByName('accounts.view.'.$account->getKey());
})->throws(PermissionDoesNotExist::class);
