<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use HasFactory, Uuid, SoftDeletes, Timestamp;

    public $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function profitLossAccount()
    {
        return $this->hasOne(ProfitLossAccount::class);
    }

    // public function positionNormal(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value === 'C' ? 'Credit' : 'Debet',
    //         // set: fn($value) => Crypt::encryptString($value),
    //     );
    // }
}
