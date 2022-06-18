<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    public $timestamps =  false;
    public function subcategory(){
        return $this->hasMany(ServiceSubCategory::class,'service_categorie_id');
    }

}
