<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient_info extends Model
{
    
    protected $table = "patient_info";
    protected $primaryKey = "id";
    protected $fillable = [
        'patient_first_name','patient_last_name','patient_picture_name','patient_picture_location',
         'patient_email','patient_phone','patient_alternet_phone','patient_address','patient_area',
         'patient_city','patient_country','bsn_number','dob_number','insurance_number','emergency_contact',
         'age','sex','marital_status','medical_history','date_of_birth','blood_group',
         'occupation','admin_remarks','patient_password','status','create_by','create_date',
         'modified_by','modified_date'
    ];
    public $timestamps = false;

    public function file_info(){
       
        return $this->hasOne(Patient_file_upload::class, 'patient_id');
        // return $this->hasOne('App\Patient_file_upload','patient_id');
        
    }
}
