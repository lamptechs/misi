<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket_department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TicketDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ticket_department::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),[
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4'    
            ]);
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }
   
            $ticket_department = new Ticket_department();
            $ticket_department->department_name = $request->name;
            $ticket_department->status = $request->status;
            $ticket_department->remarks = $request->remarks ?? "";
            $ticket_department->create_by = 1;
            $ticket_department->create_date = Carbon::Now();
            $ticket_department->save();
            return $ticket_department;
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4'
    
            ]
           );
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }
   
            $ticket_department = Ticket_department::find($id);
            $ticket_department->department_name = $request->name;
            $ticket_department->status = $request->status;
            $ticket_department->remarks = $request->remarks ?? "";
            $ticket_department->modified_by = 1;
            $ticket_department->modified_date = Carbon::Now();
            $ticket_department->save();
            return $ticket_department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Ticket_department::destroy($id);
    }
}
