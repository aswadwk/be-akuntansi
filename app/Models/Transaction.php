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

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';

    protected $fillable = [
        'code',
        'user_id',
        'status',
    ];

    public function journals()
    {
        return $this->hasMany(Journal::class, 'transaction_id', 'id');
    }
}
