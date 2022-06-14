<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Therapist_type;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TherapistTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Therapist_type::all();
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
   
            $therapist_type = new Therapist_type();
            $therapist_type->therapist_type_name = $request->name;
            $therapist_type->status = $request->status;
            $therapist_type->remarks = $request->remarks ?? "";
            $therapist_type->create_by = 1;
            $therapist_type->create_date = Carbon::Now();
            $therapist_type->save();
            return $therapist_type;
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
   
            $therapist_type = Therapist_type::find($id);
            $therapist_type->therapist_type_name = $request->name;
            $therapist_type->status = $request->status;
            $therapist_type->remarks = $request->remarks ?? "";
            $therapist_type->modified_by = 1;
            $therapist_type->modified_date = Carbon::Now();
            $therapist_type->save();
            return $therapist_type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Therapist_type::destroy($id);
    }
}
