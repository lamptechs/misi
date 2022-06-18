<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function file_info(){
       
        return $this->hasOne(TherapistUpload::class, 'therapist_id');
        
    }
}
