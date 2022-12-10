<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    protected $primeryKey='expert_id';
    public function user()
    {
        return $this->belongsTo(User::class);
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
    public function experience()
    {
        return $this->hasMany(Experience::class);
    }
    public function work_time()
    {
        return $this->hasMany(Work_time::class);
    }
    public function expert_consultation_type()
    {
        return $this->hasMany(ExpertConsultationType::class);
    }
}
