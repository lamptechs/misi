<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_department extends Model
{
    
    protected $table = "ticket_department";
    protected $primaryKey = "id";
    protected $fillable = [
        'department_name','status','remarks','create_by','create_date','modified_by','modified_date'
    ];
    public $timestamps = false;

    
}
