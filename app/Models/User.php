<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $name
 * @property string                                                                                                    $login
 * @property string                                                                                                    $email
 * @property \Illuminate\Support\Carbon|null                                                                           $email_verified_at
 * @property string                                                                                                    $password
 * @property string|null                                                                                               $two_factor_secret
 * @property string|null                                                                                               $two_factor_recovery_codes
 * @property string|null                                                                                               $two_factor_confirmed_at
 * @property string|null                                                                                               $remember_token
 * @property int|null                                                                                                  $current_team_id
 * @property string|null                                                                                               $profile_photo_path
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Account[]                                            $boughtAccounts
 * @property int|null                                                                                                  $bought_accounts_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountType[]                                        $createdAccountTypes
 * @property int|null                                                                                                  $created_account_types_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Account[]                                            $createdAccounts
 * @property int|null                                                                                                  $created_accounts_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Game[]                                               $createdGames
 * @property int|null                                                                                                  $created_games_count
 * @property string                                                                                                    $profile_photo_url
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null                                                                                                  $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[]                                         $permissions
 * @property int|null                                                                                                  $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Role[]                                               $roles
 * @property int|null                                                                                                  $roles_count
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[]                           $tokens
 * @property int|null                                                                                                  $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
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

    public function canAccessFilament(): bool
    {
        return $this->hasPermissionTo('view.admin-page');
    }
}
