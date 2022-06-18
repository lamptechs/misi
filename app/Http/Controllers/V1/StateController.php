<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return State::all();
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
                'remarks' => 'nullable|min:4'
    
            ]
           );
            
           if ($validator->fails()) {
    
            $this->apiOutput($this->getValidationError($validator), 200);
           }
   
            $state = new State();
            $state->name = $request->name;
            $state->status = $request->status;
            $state->created_by = 1;
            $state->created_at = Carbon::Now();
            $state->save();
            $this->apiSuccess();
            // $this->data = (new ServiceCategoryResource($service));
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
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
       
                $state = State::find($id);
                $state->name = $request->name;
                $state->status = $request->status;
                $state->updated_by = 1;
                $state->updated_at = Carbon::Now();
                $state->save();
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
        State::destroy($id);
        $this->apiSuccess();
        return $this->apiOutput("State Deleted Successfully", 200);
    }
}
