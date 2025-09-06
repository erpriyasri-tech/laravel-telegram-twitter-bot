<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'update_id','message_id','chat_id','chat_title','message_text',
        'raw_update','rewritten_text','posted_to_x','posted_at','tweet_id','message_date'
    ];

    protected $casts = [
        'raw_update' => 'array',
        'posted_to_x' => 'boolean',
        'message_date' => 'datetime',
        'posted_at' => 'datetime',
    ];
}
