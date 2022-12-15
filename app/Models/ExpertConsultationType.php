<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExpertConsultationType extends Pivot
{
    use HasFactory;
    protected $table = 'expert_consultation_types';
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
    public function expert_consultation_type()
    {
        return $this->belongsTo(ExpertConsultationType::class);
    }
    protected $fillable=['expert_id','consultation_type_id'];
    public $timestamps=false;

}
