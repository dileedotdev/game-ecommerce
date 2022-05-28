<?php

namespace App\Models;

use App\Actions\Permission\Create;
use App\Actions\Permission\Delete;
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
        static::created(function (self $type): void {
            $key = $type->getKey();
            Create::run("account_types.view.{$key}", $type->creator, "Can view account_types:{$key} (include important infos)");
            Create::run("account_types.add_accounts.{$key}", $type->creator, "Can use account_types:{$key} to create accounts");
            Create::run("account_types.update.{$key}", $type->creator, "Can update account_types:{$key}");
            Create::run("account_types.delete.{$key}", $type->creator, "Can delete account_types:{$key}");
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Delete::run("account_types.view.{$key}");
            Delete::run("account_types.add_accounts.{$key}");
            Delete::run("account_types.update.{$key}");
            Delete::run("account_types.delete.{$key}");
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
