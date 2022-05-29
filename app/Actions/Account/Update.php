<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class Update
{
    use AsAction;

    public function handle(
        Account $account,
        ?string $description = null,
        ?array $infos = null,
    ): void {
        DB::beginTransaction();
        try {
            $result = $account->forceFill([
                'description' => $description,
            ])->save();

            if (!$result) {
                throw new \Exception('Failed to update account');
            }

            if (null !== $infos) {
                $account->infos->each(fn (AccountInfo $info) => DeleteInfo::run($info));

                $fields = AccountField::whereIn('id', array_reverse($infos))->get();
                foreach ($infos as $key => $value) {
                    CreateInfo::run($account, $fields->where('id', $key)->first(), $value);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
