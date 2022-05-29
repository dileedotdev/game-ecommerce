<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use Lorisleiva\Actions\Concerns\AsAction;

class Update
{
    use AsAction;

    public function handle(
        Account $account,
        ?string $description = null,
        ?array $infos = null,
    ): void {
        $result = $account->forceFill([
            'description' => $description,
        ])->save();

        if (!$result) {
            throw new \Exception('Failed to update account');
        }

        if (null !== $infos) {
            $account->infos->each(fn (AccountInfo $info) => DeleteInfo::run($info));

            foreach (AccountField::whereIn('id', array_flip($infos))->get() as $field) {
                CreateInfo::run($account, $field, $infos[$field->getKey()]);
            }
        }
    }
}
