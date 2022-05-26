<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\RoleResource;
use Filament\Resources\RelationManagers\MorphToManyRelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;

class RolesRelationManager extends MorphToManyRelationManager
{
    protected static string $relationship = 'roles';

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
        return RoleResource::table($table);
    }
}
