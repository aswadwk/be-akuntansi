<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfitLossAccount extends Model
{
    use HasFactory, SoftDeletes, Timestamp, Uuid;

    protected $fillable = [
        'account_type_id',
    ];
}
