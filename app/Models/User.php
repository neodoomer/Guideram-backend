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
        return $this->belongsToMany(Expert::class, 'ratings', 'user_id', 'expert_id')->withTimestamps();
    }
    public function favoriting()
    {
        return $this->belongsToMany(Expert::class, 'favoritings', 'user_id', 'expert_id')->withTimestamps();
    }
    public function conversation()
    {
        return $this->belongsToMany(Conversation::class);
    }
    //configes
    protected $fillable=['name','email','password','photo','is_expert'];
    public $timestamps=false;
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
