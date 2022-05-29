<?php

namespace App\Models;

use App\Actions\Permission\Create;
use App\Actions\Permission\Delete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'publisher_name',
        'description',
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
            Create::run("games.view.{$key}", $account->creator, "Can view games:{$key} (include important infos)");
            Create::run("games.update.{$key}", $account->creator, "Can update games:{$key}");
            Create::run("games.delete.{$key}", $account->creator, "Can delete games:{$key}");
        });

        static::deleted(function (self $account): void {
            $key = $account->getKey();
            Delete::run("games.view.{$key}");
            Delete::run("games.update.{$key}");
            Delete::run("games.delete.{$key}");
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
