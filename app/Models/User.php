<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, Wallet
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use HasWallet;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'login',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasPermissionTo('view.admin-page');
    }

    public function createdGames(): HasMany
    {
        return $this->hasMany(Game::class, 'creator_id');
    }

    public function createdAccountTypes(): HasMany
    {
        return $this->hasMany(AccountType::class, 'creator_id');
    }

    public function createdAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'creator_id');
    }

    public function boughtAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'buyer_id');
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balanceInt);
    }
}
