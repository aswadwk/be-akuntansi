<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory, Uuid, SoftDeletes, Timestamp;

    protected $guarded = [];
}
