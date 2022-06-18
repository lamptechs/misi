<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Degree;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Degree::all();
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:2',
    
            ]
           );
            
           if ($validator->fails()) {
    
            $this->apiOutput($this->getValidationError($validator), 200);
           }
   
            $degree = new Degree();
            $degree->name = $request->name;
            $degree->status = $request->status;
            $degree->created_by = 1;
            $degree->created_at = Carbon::Now();
            $degree->save();
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:2',
                'remarks' => 'nullable|min:4'
    
            ]
           );
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }
   
            $degree = Degree::find($id);
            $degree->name = $request->name;
            $degree->status = $request->status;
            $degree->updated_by = 1;
            $degree->updated_at = Carbon::Now();
            $degree->save();
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
        Degree::destroy($id);
        $this->apiSuccess();
        return $this->apiOutput("Degree Deleted Successfully", 200);
    }
}
