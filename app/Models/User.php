<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $primaryKey='user_id';
    public function expert()
    {
        return $this->hasOne(Expert::class,"expert_id","user_id");
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

    //configes
    protected $fillable=['name','email','password','photo','is_expert'];
    public $timestamps=false;
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
