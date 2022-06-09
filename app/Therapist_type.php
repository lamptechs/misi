<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist_Type extends Model
{
    
    protected $table = "therapist_type";
    protected $primaryKey = "id";
    protected $fillable = [
        'therapist_type_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
