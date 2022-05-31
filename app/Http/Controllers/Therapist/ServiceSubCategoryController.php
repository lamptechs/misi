<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service_SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ServiceSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Service_SubCategory::all();
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
   
            $subservice = new Service_SubCategory();
            $subservice->service_subcategory_name = $request->name;
            $subservice->status = $request->status;
            $subservice->remarks = $request->remarks ?? "null";
            $subservice->create_by = 1;
            $subservice->create_date = Carbon::Now();
            $subservice->service_category_id = $request->service_category_id;
            $subservice->save();
            return $subservice;
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
   
            $subservice = Service_SubCategory::find($id);
            $subservice->service_subcategory_name = $request->name;
            $subservice->status = $request->status;
            $subservice->remarks = $request->remarks ?? "null";
            $subservice->modified_by = 1;
            $subservice->modified_date = Carbon::Now();
            $subservice->service_category_id = $request->service_category_id;
            $subservice->save();
            return $subservice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Service_SubCategory::destroy($id);
    }
}
