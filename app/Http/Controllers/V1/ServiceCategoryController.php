<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use Illuminate\Http\Request;
use App\Service_Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    //Get All Value
    public function index(){
        return Service_Category::all();
    }

    public function store(Request $request){

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'remarks' => 'nullable|min:4' 
            ]);
             
            if ($validator->fails()) {
    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
    
            $service = new Service_Category();
            $service->service_category_name = $request->name;
            $service->status = $request->status;
            $service->remarks = $request->remarks ?? "";
            $service->create_by = 1;
            $service->create_date = Carbon::Now();
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

         $service = Service_Category::find($id);
         $service->service_category_name = $request->name;
         $service->status = $request->status;
         $service->remarks = $request->remarks ?? "";
        //  $service->create_by = 1;
        //  $service->create_date = Carbon::Now();
         $service->modified_by = 1;
         $service->modified_date = Carbon::Now();
         $service->save();
         return $service;
     }

     //Service Destroy
     public function destroy($id){

        return Service_Category::destroy($id);
    }
}
