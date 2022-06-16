<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    //Get All Value
    public function index(){
        return ServiceCategory::all();
    }

    public function store(Request $request){

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4' 
            ]);
             
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 200);
            }
    
            $service = new ServiceCategory();
            $service->name = $request->name;
            $service->status = $request->status;
            $service->remarks = $request->remarks ?? "";
            $service->created_by = 1;
            $service->created_at = Carbon::Now();
            $service->save();
            
            $this->apiSuccess();
            $this->data = (new ServiceCategoryResource($service));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

     //Update Service
     public function update(Request $request, $id){

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4' 
            ]);
             
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
    
            $service = ServiceCategory::find($id);
            $service->name = $request->name;
            $service->status = $request->status;
            $service->remarks = $request->remarks ?? "";
            $service->updated_by = 1;
            $service->updated_at = Carbon::Now();
            $service->save();
            
            $this->apiSuccess();
            $this->data = (new ServiceCategoryResource($service));
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
     }

     //Service Destroy
     public function destroy($id){

         ServiceCategory::destroy($id);
         $this->apiSuccess();
         return $this->apiOutput("Service Category Deleted Successfully", 200);
    }
}
