<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_session_id',
        'sender_type',
        'message_text',
        'attachments'
    ];

    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class);
    }
}
