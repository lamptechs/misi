<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    
    protected $table = "occupation";
    protected $primaryKey = "id";
    protected $fillable = [
        'occupation_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
