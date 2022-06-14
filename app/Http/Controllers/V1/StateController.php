<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\State_city;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return State_city::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
   
            $state = new State_city();
            $state->state_city_name = $request->name;
            $state->status = $request->status;
            $state->remarks = $request->remarks ?? "";
            $state->create_by = 1;
            $state->create_date = Carbon::Now();
            $state->save();
            return $state;
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
        //
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
   
            $state = State_city::find($id);
            $state->state_city_name = $request->name;
            $state->status = $request->status;
            $state->remarks = $request->remarks ?? "";
            $state->modified_by = 1;
            $state->modified_date = Carbon::Now();
            $state->save();
            return $state;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return State_city::destroy($id);
    }
}
