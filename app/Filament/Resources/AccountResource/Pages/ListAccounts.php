<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

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
}
