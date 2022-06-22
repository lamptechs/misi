<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistDegree extends Model
{
    use HasFactory;
    public function therapist(){
        return $this->belongsTo(Therapist::class, 'therapist_id'); 
    }
    public function degree(){
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
