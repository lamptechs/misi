<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TherapistUpload extends Model
{
    use HasFactory, SoftDeletes;
    
    public function therapist(){
        return $this->belongsTo(Therapist::class, 'id');
    }
}
