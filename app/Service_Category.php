<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_Category extends Model
{
    protected $table = "service_category";
    protected $primaryKey = "id";
    protected $fillable = [
        'service_category_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;
}

