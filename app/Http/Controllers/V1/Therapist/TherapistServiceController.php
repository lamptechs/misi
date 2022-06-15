<?php

namespace App\Http\Controllers\Therapist\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Therapist_Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TherapistServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Therapist_Service::all();
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
   
            $therapistservice = new Therapist_Service();
            $therapistservice->therapist_service_name = $request->name;
            $therapistservice->status = $request->status;
            $therapistservice->remarks = $request->remarks ?? "";
            $therapistservice->create_by = 1;
            $therapistservice->create_date = Carbon::Now();
            $therapistservice->service_category_id = $request->service_category_id;
            $therapistservice->service_subcategory_id = $request->service_subcategory_id;
            $therapistservice->save();
            return $therapistservice;
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
   
            $therapistservice = Therapist_Service::find($id);
            $therapistservice->therapist_service_name = $request->name;
            $therapistservice->status = $request->status;
            $therapistservice->remarks = $request->remarks ?? "";
            $therapistservice->modified_by = 1;
            $therapistservice->modified_date = Carbon::Now();
            $therapistservice->service_category_id = $request->service_category_id;
            $therapistservice->service_subcategory_id = $request->service_subcategory_id;
            $therapistservice->save();
            return $therapistservice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Therapist_Service::destroy($id);
    }
}
