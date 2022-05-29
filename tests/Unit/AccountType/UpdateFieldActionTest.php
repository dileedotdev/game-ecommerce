<?php

use App\Actions\AccountType\UpdateField;
use App\Models\AccountField;

beforeEach(function (): void {
    $this->field = AccountField::factory()->create();
});

it('should create correctly', function (): void {
    UpdateField::run(
        accountField: $this->field,
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

    expect($this->field->name)->toBe('New Field');
    expect($this->field->regex)->toBe('^[a-zA-Z0-9]{1,255}$');
    expect($this->field->is_required)->toBe(true);
    expect($this->field->can_create_by_creator)->toBe(true);
    expect($this->field->can_update_by_creator)->toBe(true);
    expect($this->field->can_delete_by_creator)->toBe(true);
    expect($this->field->can_view_by_anyone)->toBe(true);
    expect($this->field->can_view_by_creator)->toBe(false);
    expect($this->field->can_view_by_unconfirmed_buyer)->toBe(true);
    expect($this->field->can_view_by_confirmed_buyer)->toBe(true);
});
