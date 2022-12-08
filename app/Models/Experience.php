<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $primeryKey = 'experience_id';
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
