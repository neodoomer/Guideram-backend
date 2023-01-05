<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $primaryKey='message_id';
    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    protected $fillable=["conversation_id","is_user","text"];
}
