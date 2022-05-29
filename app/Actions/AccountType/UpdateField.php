<?php

namespace App\Actions\AccountType;

use App\Models\AccountField;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateField
{
    use AsAction;

    public function handle(
        AccountField $accountField,
        string $name,
        ?string $regex,
        bool $isRequired,
        bool $canCreateByCreator,
        bool $canUpdateByCreator,
        bool $canDeleteByCreator,
        bool $canViewByAnyone,
        bool $canViewByCreator,
        bool $canViewByUnconfirmedBuyer,
        bool $canViewByConfirmedBuyer,
    ): void {
        $result = $accountField->forceFill([
            'name' => $name,
            'regex' => $regex,
            'is_required' => $isRequired,
            'can_create_by_creator' => $canCreateByCreator,
            'can_update_by_creator' => $canUpdateByCreator,
            'can_delete_by_creator' => $canDeleteByCreator,
            'can_view_by_anyone' => $canViewByAnyone,
            'can_view_by_creator' => $canViewByCreator,
            'can_view_by_unconfirmed_buyer' => $canViewByUnconfirmedBuyer,
            'can_view_by_confirmed_buyer' => $canViewByConfirmedBuyer,
        ])->save();

        if (!$result) {
            throw new \Exception('Failed to update account field');
        }
    }
}
