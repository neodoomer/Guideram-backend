<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertConsultationType extends Model
{
    use HasFactory;
    protected $primaryKey=['expert_id','consultation_type_id'];
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
    public function expert_consultation_type()
    {
        return $this->belongsTo(ExpertConsultationType::class);
    }

}
