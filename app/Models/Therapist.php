<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Therapist extends Model
{

    use SoftDeletes; 

    public function fileInfo(){
       
        return $this->hasOne(TherapistUpload::class, 'therapist_id');
        
    }

    public function blood(){
       
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
        
    }
    public function country(){
       
        return $this->belongsTo(Country::class, 'country_id');
        
    }
    public function state(){
       
        return $this->belongsTo(State::class, 'state_id');
        
    }
    public function therapistType(){
       
        return $this->belongsTo(TherapistType::class, 'therapist_type_id');
        
    }
}
