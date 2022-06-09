<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blood_group extends Model
{
    
    protected $table = "blood_group";
    protected $primaryKey = "id";
    protected $fillable = [
        'blood_group_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
