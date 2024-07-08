<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, Uuid, SoftDeletes, Timestamp;

    const REPORT_POSITION_BALANCE_SHEET = 'balance sheet';  // Neraca
    const REPORT_POSITION_PROFIT_LOSS = 'profit and loss';  // Laba Rugi

    public $guarded = [];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => + ($value),
        );
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'account_id', 'id');
    }
}
