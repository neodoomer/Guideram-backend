<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $primaryKey='consultation_id';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
    protected $fillable=["user_id","expert_id","day","from"];
    
}
