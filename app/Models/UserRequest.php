<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'request_type',
        'user_id',
        'payload',
        'status',
        'approved_by'
    ];
}
