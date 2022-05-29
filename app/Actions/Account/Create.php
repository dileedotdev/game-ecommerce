<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountType;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class Create
{
    use AsAction;

    /**
     * @param array<int, string> $infos
     */
    public function handle(
        AccountType $accountType,
        User $creator,
        ?string $description = null,
        array $infos = []
    ): Account {
        $account = Account::forceCreate([
            'account_type_id' => $accountType->id,
            'description' => $description,
            'creator_id' => $creator->id,
        ]);

        if ($infos) {
            $fields = AccountField::whereIn('id', array_flip($infos))->get();
            foreach ($fields as $field) {
                CreateInfo::run($account, $field, $infos[$field->getKey()]);
            }
        }

        return $account;
    }
}
