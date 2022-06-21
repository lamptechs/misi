<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientUpload extends Model
{
    use HasFactory;
   
    public function patient(){
        return $this->belongsTo(User::class, 'id');
    }
}
