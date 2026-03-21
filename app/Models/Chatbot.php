<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $table = 'chatbots';

    protected $fillable = [
        'user_id',
        'user_message',
        'bot_reply',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
