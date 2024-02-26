<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingReport extends Model
{
    use HasFactory, SoftDeletes, Timestamp;

    const TYPE_PROFIT_LOSS = 'profit loss';
    const TYPE_BALANCE_SHEET = 'balance sheet';

    const PROFIT_LOSS_TYPE = [
        'profit' => 'profit',
        'loss' => 'loss'
    ];

    protected $fillable = [
        'report_type',
        'title',
        'type',
        'sub_title',
        'order',
        'account_ids',
        'created_by'
    ];
}
