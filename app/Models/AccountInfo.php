<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AccountInfo.
 *
 * @property int                             $id
 * @property int                             $account_id
 * @property int                             $account_field_id
 * @property string                          $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Account             $account
 * @property \App\Models\AccountField|null   $field
 *
 * @method static \Database\Factories\AccountInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereAccountFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccountInfo whereValue($value)
 * @mixin \Eloquent
 */
class AccountInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
    ];

    protected $hidden = [
        'value',
    ];

    protected $casts = [
    ];

    protected $appends = [
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(AccountField::class, 'account_field_id');
    }
}
