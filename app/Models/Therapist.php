<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Therapist extends Model
{

    use SoftDeletes; 

    public function file_info(){
       
        return $this->hasOne(TherapistUpload::class, 'therapist_id');
        
    }
}
