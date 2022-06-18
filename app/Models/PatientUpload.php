<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientUpload extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function patient(){
        // return $this->hasOne(Patient_info::class);
        return $this->belongsTo(User::class, 'id');
        // return $this->belongsTo('App\Patient_info');
    }
}
