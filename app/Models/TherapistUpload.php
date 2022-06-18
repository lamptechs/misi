<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistUpload extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function therapist(){
        return $this->belongsTo(Therapist::class, 'id');
    }
}
