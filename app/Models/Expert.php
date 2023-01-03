<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    protected $primaryKey='expert_id';
    public function user()
    {
        return $this->belongsTo(User::class,"expert_id","user_id");
    }
    public function consultation()
    {
        return $this->belongsToMany(Consultation::class,"consultations","expert_id","user_id")->using(Consultation::class);
    }
    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function favoriting()
    {
        return $this->hasMany(Favoriting::class);
    }
    public function work_time()
    {
        return $this->hasMany(Work_time::class,"expert_id","expert_id");
    }
    public function expert_consultation_types()
    {
        return $this->belongsToMany(Consultation_type::class,'expert_consultation_types', 'expert_id', 'consultation_type_id')->using(ExpertConsultationType::class);
    }
    public function conversation()
    {
        return $this->belongsToMany(Conversation::class);
    }
    protected $fillable=['expert_id','experience','phone','address','cost','duration',];
    public $timestamps=false;
    public function scopeFilter($query)
    {
        if($filters['type'] ?? false){
            $query
            ->join('users','user_id','=','expert_id')
            ->join('expert_consultation_types','expert_consultation_types.expert_id','experts.expert_id')
            ->join('consultation_types', 'consultation_types.consultation_type_id', '=', 'expert_consultation_types.consultation_type_id')
            ->select('users.*','experts.*')
            ->where('type','like',request('type'));
        }
        if($filters['search'] ?? false){
            $query
           ->join('users','user_id','=','expert_id')
           ->where('name','like','%',request('search'),'%')
           ->orWhere('experience','like','%',request('search'),'%');
        }
    }


}
