<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    // public function state(){
       
    //     return $this->belongsTo(User::class, 'id');
        
    // }
    public function User(){
        return $this->hasMany(User::class, 'state_id');
    }
}
