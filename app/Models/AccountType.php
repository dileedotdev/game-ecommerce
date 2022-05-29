<?php

namespace App\Models;

use App\Actions\Permission\Create;
use App\Actions\Permission\Delete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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
