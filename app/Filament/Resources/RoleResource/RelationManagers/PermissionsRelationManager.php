<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Filament\Resources\PermissionResource;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;

class PermissionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'permissions';

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
        return PermissionResource::table($table);
    }
}
