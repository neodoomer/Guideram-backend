<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $primaryKey='conversation_id';
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function expert()
    {
        return $this->hasOne(Expert::class);
    }
    protected $fillable=["conversation_id"];
}
