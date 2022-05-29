<?php

namespace App\Actions\AccountType;

use App\Actions\Account\DeleteInfo;
use App\Models\AccountField;
use App\Models\AccountInfo;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteField
{
    use AsAction;

    public function handle(AccountField $field): void
    {
        DB::transaction(function () use ($field): void {
            $field->infos->each(fn (AccountInfo $info) => DeleteInfo::run($info));
            if (!$field->delete()) {
                throw new \Exception('Failed to delete account field');
            }
        });
    }
}
