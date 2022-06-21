<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public function patient(){
       
        return $this->belongsTo(User::class, 'patient_id');
        
    }
    public function therapist(){
       
        return $this->belongsTo(Therapist::class, 'therapist_id');
        
    }
    public function ticketDepartment(){
       
        return $this->belongsTo(TicketDepartment::class, 'ticket_department_id');
        
    }
}
