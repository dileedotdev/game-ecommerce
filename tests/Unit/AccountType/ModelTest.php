<?php

use App\Models\AccountType;
use App\Models\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

it('create related permission and give to creator on creating', function (): void {
    $accountType = AccountType::factory()->create();

    expect(Permission::findByName('account_types.view.'.$accountType->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('account_types.update.'.$accountType->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('account_types.add_accounts.'.$accountType->getKey()))->toBeInstanceOf(Permission::class);
    expect(Permission::findByName('account_types.delete.'.$accountType->getKey()))->toBeInstanceOf(Permission::class);

    expect($accountType->creator->hasPermissionTo('account_types.view.'.$accountType->getKey()))->toBeTrue();
    expect($accountType->creator->hasPermissionTo('account_types.update.'.$accountType->getKey()))->toBeTrue();
    expect($accountType->creator->hasPermissionTo('account_types.add_accounts.'.$accountType->getKey()))->toBeTrue();
    expect($accountType->creator->hasPermissionTo('account_types.delete.'.$accountType->getKey()))->toBeTrue();
});

it('delete related permission on deleting', function (): void {
    $accountType = AccountType::factory()->create();
    $accountType->delete();

    $accountType->creator->load('permissions');

    expect($accountType->creator->hasPermissionTo('account_types.view.'.$accountType->getKey()))->toBeFalse();
    expect($accountType->creator->hasPermissionTo('account_types.update.'.$accountType->getKey()))->toBeFalse();
    expect($accountType->creator->hasPermissionTo('account_types.add_accounts.'.$accountType->getKey()))->toBeFalse();
    expect($accountType->creator->hasPermissionTo('account_types.delete.'.$accountType->getKey()))->toBeFalse();

    Permission::findByName('account_types.view.'.$accountType->getKey());
})->throws(PermissionDoesNotExist::class);
