<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AccountType.
 *
 * @property int                                                                 $id
 * @property string                                                              $name
 * @property string|null                                                         $description
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property int                                                                 $game_id
 * @property int                                                                 $creator_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Account[]      $accounts
 * @property int|null                                                            $accounts_count
 * @property \App\Models\User                                                    $creator
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountField[] $fields
 * @property int|null                                                            $fields_count
 * @property \App\Models\Game                                                    $game
 *
 * @method static \Database\Factories\AccountTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'game_id',
        'creator_id',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];

    protected static function booted(): void
    {
        static::created(function (self $account): void {
            $key = $account->getKey();

            $account->creator->givePermissionTo(
                Permission::create(['name' => "account_types.view.{$key}", 'description' => "Can view account_types:{$key} (include important infos)"]),
                Permission::create(['name' => "account_types.update.{$key}", 'description' => "Can update account_types:{$key} and any related accounts"]),
                Permission::create(['name' => "account_types.delete.{$key}", 'description' => "Can delete account_types:{$key}"]),
            );
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Permission::findByName("account_types.view.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("account_types.update.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("account_types.delete.{$key}")->delete(); /** @phpstan-ignore-line */
        });
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(AccountField::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
