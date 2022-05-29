<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountInfo;
use Lorisleiva\Actions\Concerns\AsAction;

class Delete
{
    use AsAction;

    public function handle(Account $account): void
    {
        $account->infos->each(fn (AccountInfo $info) => DeleteInfo::run($info));
        $result = $account->delete();

        if (!$result) {
            throw new \Exception('Failed to delete account');
        }
    }
}
