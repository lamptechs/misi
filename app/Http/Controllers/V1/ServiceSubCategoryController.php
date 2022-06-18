<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceSubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ServiceSubCategoryResource;

class ServiceSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subs = ServiceSubCategory::all();
        foreach($subs as $sub){
            if($sub->status == 1){
                $status = 'Active';
            }
            if($sub->status == 0){
                $status = 'Inactive';
            }
        $params =[
            "Service Category Name" => $sub->category->name,
            "Name" => $sub->name,
            "Status" => $status,
            "Remarks" => $sub->remarks,
            "Created By" => $sub->created_by,
            "Updated By" => $sub->updated_by,
            "Created At" => $sub->created_at,
            "Updated At" => $sub->updated_at

        ];
    }
        return $params;
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
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4' 
            ]);
             
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 200);
            }
    
            $subservice = new ServiceSubCategory();
            $subservice->service_categorie_id = $request->service_categorie_id;
            $subservice->name = $request->name;
            $subservice->status = $request->status;
            $subservice->remarks = $request->remarks ?? "";
            $subservice->created_by = 1;
            $subservice->created_at = Carbon::Now();
            $subservice->save();
            
            $this->apiSuccess();
            $this->data = (new ServiceSubCategoryResource($subservice));
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
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4' 
            ]);
             
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 200);
            }
    
            $subservice = ServiceSubCategory::find($id);
            $subservice->service_categorie_id = $request->service_categorie_id;
            $subservice->name = $request->name;
            $subservice->status = $request->status;
            $subservice->remarks = $request->remarks ?? "";
            $subservice->updated_by = 1;
            $subservice->updated_at = Carbon::Now();
            $subservice->save();
            
            $this->apiSuccess();
            $this->data = (new ServiceSubCategoryResource($subservice));
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
        ServiceSubCategory::destroy($id);
        $this->apiSuccess();
        return $this->apiOutput("Service SubCategory Deleted Successfully", 200);
    }
}
