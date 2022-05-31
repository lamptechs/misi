<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Therapist_Service extends Model
{
    protected $table = "therapist_service";
    protected $primaryKey = "id";
    protected $fillable = [
        'therapist_service_name','status','remarks','create_by','create_date','modified_by','modified_date','service_category_id',
        'service_subcategory_id'
    ];
    public $timestamps = false;
}
