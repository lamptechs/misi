<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
Use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ticket::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
           $validator = Validator::make( $request->all(),[
                'patient_id' => 'required',
                'therapist_id' => 'required'    
            ]);
            
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 200);
            }
   
            $ticket = new Ticket();
            $ticket->patient_id = $request->patient_id;
            $ticket->therapist_id = $request->therapist_id;
            $ticket->ticket_department_id = $request->ticket_department_id;
            $ticket->location = $request->location;
            $ticket->language = $request->language;
            $ticket->date = /*$request->date*/ Carbon::now();
            $ticket->strike = $request->strike;
            $ticket->strike_history = $request->strike_history ?? "";
            $ticket->ticket_history = $request->ticket_history ?? "";
            $ticket->remarks = $request->remarks ?? "";
            $ticket->status = $request->status;
            $ticket->created_by = 1;
            $ticket->created_at = Carbon::Now();
            $ticket->save();
            $this->apiSuccess();
            // $this->data = (new ServiceCategoryResource($service));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
        $validator = Validator::make(
            $request->all(),
            [
                'patient_id' => 'required',
                'therapist_id' => 'required' 
    
            ]
           );
            
           if ($validator->fails()) {
    
            $this->apiOutput($this->getValidationError($validator), 200);
           }
   
            $ticket = TicketDepartment::find($id);
            $ticket->patient_id = $request->patient_id;
            $ticket->therapist_id = $request->therapist_id;
            $ticket->ticket_department_id = $request->ticket_department_id;
            $ticket->location = $request->location;
            $ticket->language = $request->language;
            $ticket->date = /*$request->date*/ Carbon::now();
            $ticket->strike = $request->strike;
            $ticket->strike_history = $request->strike_history ?? "";
            $ticket->ticket_history = $request->ticket_history ?? "";
            $ticket->remarks = $request->remarks ?? "";
            $ticket->status = $request->status;
            $ticket->updated_by = 1;
            $ticket->updated_at = Carbon::Now();
            $ticket->save();
            $this->apiSuccess();
            // $this->data = (new ServiceCategoryResource($service));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::destroy($id);
        $this->apiSuccess();
        return $this->apiOutput("Ticket Deleted Successfully", 200);
    }
}
