<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use App\Filament\Resources\AccountTypeResource;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;

class AccountTypesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'accountTypes';

    protected static ?string $recordTitleAttribute = 'name';

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return false;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }

    protected function canDelete(Model $record): bool
    {
        return false;
    }

    protected function canDetachAny(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return AccountTypeResource::table($table);
    }
}
