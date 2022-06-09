<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State_city extends Model
{
    
    protected $table = "state_city";
    protected $primaryKey = "id";
    protected $fillable = [
        'state_city_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
