<?php

namespace App\Filament\Resources\AccountTypeResource\Pages;

use App\Actions\AccountType\Create;
use App\Actions\AccountType\GiveAddAccountsPermissionToUsers;
use App\Filament\Resources\AccountTypeResource;
use App\Models\Game;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAccountType extends CreateRecord
{
    protected static string $resource = AccountTypeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $type = Create::run(
            game: Game::findOrFail($data['game_id']),
            creator: Filament::auth()->user(),
            name: $data['name'],
            description: $data['description'],
        );

        if ($data['usable_user_logins']) {
            GiveAddAccountsPermissionToUsers::run($type, users: User::whereIn('login', $data['usable_user_logins'])->get());
        }

        return $type;
    }
}
