<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist_degree extends Model
{
    
    protected $table = "therapist_degree";
    protected $primaryKey = "id";
    protected $fillable = [
        'degree_name','remarks','status','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
