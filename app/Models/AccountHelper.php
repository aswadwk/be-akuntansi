<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountHelper extends Model
{
    use HasFactory, SoftDeletes, Timestamp, HasUuids;

    const ACCOUNT_TYPE_DEBIT = 'debit'; // Hutang
    const ACCOUNT_TYPE_CREDIT = 'credit'; // Piutang
    const ACCOUNT_TYPE_PROJECT = 'project'; // Piutang

    protected $fillable = [
        'code',
        'name',
        'account_type',  // DEBIT, CREDIT, PROJECT
        'type', // D, C
        'description',
        'created_by',
        'opening_balance',
    ];
}
