<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $primeryKey='user_id';
    public function expert()
    {
        return $this->hasOne(Expert::class);
    }
    public function consultation()
    {
        return $this->hasMany(Consultation::class);
    }
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function favoriting()
    {
        return $this->hasMany(Favoriting::class);
    }
}
 