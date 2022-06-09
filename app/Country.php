<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    protected $table = "country";
    protected $primaryKey = "id";
    protected $fillable = [
        'country_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}