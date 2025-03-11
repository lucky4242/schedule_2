<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledSms extends Model
{
    //
    use HasFactory;

    protected $fillable = ['recipient', 'message', 'send_at', 'status'];

    protected $casts = [
        'send_at' => 'datetime',
    ];
}
