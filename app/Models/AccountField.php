<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AccountField.
 *
 * @property int                                                                $id
 * @property string                                                             $name
 * @property int                                                                $account_type_id
 * @property bool                                                               $is_required
 * @property string|null                                                        $regex
 * @property \Illuminate\Support\Carbon|null                                    $created_at
 * @property \Illuminate\Support\Carbon|null                                    $updated_at
 * @property bool                                                               $can_create_by_creator
 * @property bool                                                               $can_update_by_creator
 * @property bool                                                               $can_delete_by_creator
 * @property bool                                                               $can_view_by_anyone
 * @property bool                                                               $can_view_by_creator
 * @property bool                                                               $can_view_by_unconfirmed_buyer
 * @property bool                                                               $can_view_by_confirmed_buyer
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Account[]     $accounts
 * @property int|null                                                           $accounts_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\AccountInfo[] $infos
 * @property int|null                                                           $infos_count
 * @property \App\Models\AccountType                                            $type
 *
 * @method static \Database\Factories\AccountFieldFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanCreateByCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanDeleteByCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanUpdateByCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanViewByAnyone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanViewByConfirmedBuyer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanViewByCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCanViewByUnconfirmedBuyer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereRegex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountField whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccountField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_required',
        'regex',
        'can_create_by_creator',
        'can_update_by_creator',
        'can_delete_by_creator',
        'can_view_by_anyone',
        'can_view_by_creator',
        'can_view_by_unconfirmed_buyer',
        'can_view_by_confirmed_buyer',
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
