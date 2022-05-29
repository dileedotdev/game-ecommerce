<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountType;
use App\Models\User;
use DB;
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
        DB::beginTransaction();
        try {
            $account = $accountType->accounts()->forceCreate([
                'description' => $description,
                'creator_id' => $creator->id,
            ]);

            $fields = AccountField::whereIn('id', array_reverse($infos))->get();
            foreach ($infos as $key => $value) {
                CreateInfo::run($account, $fields->where('id', $key)->first(), $value);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $account;
    }
}
