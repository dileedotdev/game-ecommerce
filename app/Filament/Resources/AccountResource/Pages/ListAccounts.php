<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Actions\Account\Delete;
use App\Filament\Resources\AccountResource;
use App\Models\Account;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;

    protected function getTableQuery(): Builder
    {
        if (Filament::auth()->user()->can('viewAny', Account::class)) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->where('creator_id', Filament::auth()->id());
    }

    protected function handleRecordBulkDeletion(Collection $records): void
    {
        $records->each(fn (Account $account) => Delete::run($account));
    }
}
