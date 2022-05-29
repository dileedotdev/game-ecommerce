<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_required',
        'regex',
    ];

    protected $hidden = [
        'infos',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'can_create_by_creator' => 'boolean',
        'can_update_by_creator' => 'boolean',
        'can_delete_by_creator' => 'boolean',
        'can_view_by_anyone' => 'boolean',
        'can_view_by_creator' => 'boolean',
        'can_view_by_unconfirmed_buyer' => 'boolean',
        'can_view_by_confirmed_buyer' => 'boolean',
    ];

    protected $appends = [
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function infos(): HasMany
    {
        return $this->hasMany(AccountInfo::class);
    }

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'account_infos')
            ->withPivot(['value'])
            ->withTimestamps()
        ;
    }
}
