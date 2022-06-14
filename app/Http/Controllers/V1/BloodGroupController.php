<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Blood_group;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blood_group::all();
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
                'name' => 'required|min:1',
                'remarks' => 'nullable|min:4'
    
            ]
           );
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }
   
            $blood_group = new Blood_group();
            $blood_group->blood_group_name = $request->name;
            $blood_group->status = $request->status;
            $blood_group->remarks = $request->remarks ?? "";
            $blood_group->create_by = 1;
            $blood_group->create_date = Carbon::Now();
            $blood_group->save();
            return $blood_group;
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
                'name' => 'required|min:1',
                'remarks' => 'nullable|min:4'
    
            ]
           );
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }
   
            $blood_group = Blood_group::find($id);
            $blood_group->blood_group_name = $request->name;
            $blood_group->status = $request->status;
            $blood_group->remarks = $request->remarks ?? "";
            $blood_group->modified_by = 1;
            $blood_group->modified_date = Carbon::Now();
            $blood_group->save();
            return $blood_group;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Blood_group::destroy($id);
    }
}
