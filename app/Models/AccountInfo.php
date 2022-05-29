<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'account_field_id',
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

    public function getMaskedValueAttribute(): string
    {
        if ($this->field->can_view_by_anyone) {
            return $this->value;
        }

        if (!auth()->check()) {
            return '******';
        }

        if (auth()->user()->can('view', $this)) {
            return $this->value;
        }

        return '******';
    }
}
