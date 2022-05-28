<?php

namespace App\Models;

use App\Actions\Permission\Create;
use App\Actions\Permission\Delete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Account.
 *
 * @property int                                                                 $id
 * @property string|null                                                         $description
 * @property \Illuminate\Support\Carbon|null                                     $confirmed_at
 * @property \Illuminate\Support\Carbon|null                                     $created_at
 * @property \Illuminate\Support\Carbon|null                                     $updated_at
 * @property int                                                                 $account_type_id
 * @property int                                                                 $creator_id
 * @property int|null                                                            $buyer_id
 * @property \App\Models\User|null                                               $buyer
 * @property \App\Models\User                                                    $creator
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountField[] $fields
 * @property int|null                                                            $fields_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountInfo[]  $infos
 * @property int|null                                                            $infos_count
 * @property \App\Models\AccountType                                             $type
 *
 * @method static \Database\Factories\AccountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_type_id',
        'description',
        'confirmed_at',
        'creator_id',
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
            Create::run("accounts.view.{$key}", $account->creator, "Can view accounts:{$key} (include important infos)");
            Create::run("accounts.update.{$key}", $account->creator, "Can update accounts:{$key}");
            Create::run("accounts.delete.{$key}", $account->creator, "Can delete accounts:{$key}");
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Delete::run("accounts.view.{$key}");
            Delete::run("accounts.update.{$key}");
            Delete::run("accounts.delete.{$key}");
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
