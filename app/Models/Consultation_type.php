<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation_type extends Model
{
    use HasFactory;
    protected $primeryKey='consultation_type_id';
    public function expert_consultation_type()
    {
        return $this->hasMany(ExpertConsultationType::class);
    }
}
