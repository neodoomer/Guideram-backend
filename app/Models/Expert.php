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
        return $this->belongsTo(User::class );
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
    public function work_time()
    {
        return $this->hasMany(Work_time::class);
    }
    public function expert_consultation_type()
    {
        return $this->hasMany(ExpertConsultationType::class);
    }
    protected $fillable=['expert_id','experience','phone','address','cost','duration',];
    public $timestamps=false;
    public function scopeFilter($query,array $filters)
    {
        if($filters['type'] ?? false){
            $query
            ->join('users','user_id','=','expert_id')
            ->join('expert_consultation_types','expert_consultation_types.expert_id','experts.expert_id')
            ->join('consultation_types', 'consultation_types.consultation_type_id', '=', 'expert_consultation_types.consultation_type_id')
            ->select('users.*','experts.*')
            ->where('type','like',request('type'));
        }
    }
}
