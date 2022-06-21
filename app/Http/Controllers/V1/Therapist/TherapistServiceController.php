<?php

namespace App\Http\Controllers\V1\Therapist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TherapistService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Resources\TherapistServiceResource;

class TherapistServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->data = TherapistServiceResource::collection(TherapistService::all());
            return $this->apiOutput("Therapist Service Loaded Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4',
    
            ]
           );
            
           if ($validator->fails()) {
    
            $this->apiOutput($this->getValidationError($validator), 200);
           }
   
            $therapistservice = new TherapistService();
            $therapistservice->therapist_id  = $request->therapist_id ;
            $therapistservice->name = $request->name;
            $therapistservice->status = $request->status;
            $therapistservice->service_category_id  = $request->service_category_id ;
            $therapistservice->service_sub_category_id  = $request->service_sub_category_id ;
            $therapistservice->created_by = 1;
            $therapistservice->created_at = Carbon::Now();
            $therapistservice->save();
            $this->apiSuccess();
            $this->data = (new TherapistServiceResource($therapistservice));
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
   
            $therapistservice = TherapistService::find($id);
            $therapistservice->name = $request->name;
            $therapistservice->status = $request->status;
            $therapistservice->service_category_id  = $request->service_category_id ;
            $therapistservice->service_sub_category_id  = $request->service_sub_category_id ;
            $therapistservice->updated_by = 1;
            $therapistservice->updated_at = Carbon::Now();
            $therapistservice->save();
            $this->apiSuccess();
            $this->data = (new TherapistServiceResource($therapistservice));
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
        TherapistService::destroy($id);
        $this->apiSuccess();
        return $this->apiOutput("Therapist Service Deleted Successfully", 200);
    }
}
