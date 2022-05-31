<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_SubCategory extends Model
{
    protected $table = "service_subcategory";
    protected $primaryKey = "id";
    protected $fillable = [
        'service_subcategory_name','status','remarks','create_by','create_date','modified_by','modified_date','service_category_id'
    ];
    public $timestamps = false;
}
