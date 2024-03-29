<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Journal extends Model
{
    use HasFactory, Uuid, SoftDeletes, Timestamp;

    const TYPE_DEBIT = 'D';
    const TYPE_CREDIT = 'C';

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function accountHelper()
    {
        return $this->belongsTo(AccountHelper::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => + ($value),
        );
    }

    // public function accountType()
    // {
    //     return $this->belongsTo(AccountType::class);
    // }
}
