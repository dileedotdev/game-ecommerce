<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Game.
 *
 * @property int                                                                $id
 * @property string                                                             $name
 * @property string                                                             $publisher_name
 * @property string|null                                                        $description
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property int                                                                $creator_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountType[] $accountTypes
 * @property int|null                                                           $account_types_count
 * @property \App\Models\User                                                   $creator
 *
 * @method static \Database\Factories\GameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game wherePublisherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'publisher_name',
        'description',
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
                Permission::create(['name' => "games.view.{$key}", 'description' => "Can view games:{$key} (include important infos)"]),
                Permission::create(['name' => "games.update.{$key}", 'description' => "Can update games:{$key}"]),
                Permission::create(['name' => "games.delete.{$key}", 'description' => "Can delete games:{$key}"]),
            );
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Permission::findByName("games.view.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("games.update.{$key}")->delete(); /** @phpstan-ignore-line */
            Permission::findByName("games.delete.{$key}")->delete(); /** @phpstan-ignore-line */
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function accountTypes(): HasMany
    {
        return $this->hasMany(AccountType::class);
    }
}
