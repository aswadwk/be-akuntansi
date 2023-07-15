<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, Uuid, SoftDeletes, Timestamp;

    protected $fillable = [
        'code',
        'user_id',
    ];

    public function journals()
    {
        return $this->hasMany(Journal::class, 'transaction_id', 'id');
    }
}
