<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_time extends Model
{
    use HasFactory;
    protected $primaryKey='work_time_id';
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
