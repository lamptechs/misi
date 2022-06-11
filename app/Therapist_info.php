<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist_info extends Model
{
    
    protected $table = "therapist_info";
    protected $primaryKey = "id";
    protected $fillable = [
        'therapist_first_name','therapist_last_name',
         'therapist_email','therapist_phone','residential_address','language_preference',
         'bsn_number','dob_number','insurance_number','emergency_contact',
         'gender','therapist_type_id','therapist_degree_id','date_of_birth','blood_group_id','state_city_id','country_id',
         'remarks','status','create_by','create_date',
         'modified_by','modified_date'
    ];
    public $timestamps = false;

    public function file_info(){
        // return $this->belongsTo(therapist_file_upload::class, 'therapist_id');
       
        return $this->hasOne(Therapist_file_upload::class, 'therapist_id');
        // return $this->hasOne('App\therapist_file_upload','therapist_id');
        
    }
}
