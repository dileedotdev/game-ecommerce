<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Account.
 *
 * @property int                                                                 $id
 * @property int                                                                 $account_type_id
 * @property string|null                                                         $description
 * @property \Illuminate\Support\Carbon|null                                     $confirmed_at
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountField[] $fields
 * @property int|null                                                            $fields_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountInfo[]  $infos
 * @property int|null                                                            $infos_count
 * @property \App\Models\AccountType|null                                        $type
 *
 * @method static \Database\Factories\AccountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property \App\Models\User|null $buyer
 * @property \App\Models\User|null $creator
 * @property int                   $creator_id
 * @property int|null              $buyer_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereConfirmedAt($value)
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'confirmed_at',
    ];

    protected $hidden = [
        'infos',
        'fields',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    protected $appends = [
    ];

    protected static function booted(): void
    {
        static::created(function (self $account): void {
            $key = $account->getKey();

            $account->creator->givePermissionTo(
                Permission::create(['name' => "accounts.view.{$key}", 'description' => "Can view accounts:{$key} (include important infos)"]),
                Permission::create(['name' => "accounts.update.{$key}", 'description' => "Can update accounts:{$key}"]),
                Permission::create(['name' => "accounts.delete.{$key}", 'description' => "Can delete accounts:{$key}"]),
            );
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Permission::findByName("accounts.view.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("accounts.update.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("accounts.delete.{$key}")->delete(); /** @phpstan-ignore-line */
        });
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(AccountField::class, 'account_infos')
            ->withPivot(['value'])
            ->withTimestamps()
        ;
    }

    public function infos(): HasMany
    {
        return $this->hasMany(AccountInfo::class);
    }
}
