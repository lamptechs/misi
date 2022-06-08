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

    public function categories(){
        return $this->belongsTo(Service_Category::class,'service_category_id');
    }
    public function sub_categories(){
        return $this->belongsTo(Service_SubCategory::class,'service_subcategory_id');
    }
}
