<?php

use App\Actions\AccountType\CreateField;
use App\Models\AccountField;
use App\Models\AccountType;
use App\Models\User;

beforeEach(function (): void {
    $this->type = AccountType::factory()->create();
    $this->user = User::factory()->create();
});

it('should create correctly', function (): void {
    $field = CreateField::run(
        accountType: $this->type,
        name: 'New Field',
        regex: '^[a-zA-Z0-9]{1,255}$',
        isRequired: true,
        canCreateByCreator: true,
        canUpdateByCreator: true,
        canDeleteByCreator: true,
        canViewByAnyone: true,
        canViewByCreator: false,
        canViewByUnconfirmedBuyer: true,
        canViewByConfirmedBuyer: true,
    );

    expect($field)->toBeInstanceOf(AccountField::class);
    expect($field->exists())->toBeTrue();

    expect($field->account_type_id)->toBe($this->type->id);
    expect($field->name)->toBe('New Field');
    expect($field->regex)->toBe('^[a-zA-Z0-9]{1,255}$');
    expect($field->is_required)->toBe(true);
    expect($field->can_create_by_creator)->toBe(true);
    expect($field->can_update_by_creator)->toBe(true);
    expect($field->can_delete_by_creator)->toBe(true);
    expect($field->can_view_by_anyone)->toBe(true);
    expect($field->can_view_by_creator)->toBe(false);
    expect($field->can_view_by_unconfirmed_buyer)->toBe(true);
    expect($field->can_view_by_confirmed_buyer)->toBe(true);
});
