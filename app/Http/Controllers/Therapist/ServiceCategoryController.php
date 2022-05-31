<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service_Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    //Get All Value
    public function index(){
        return Service_Category::all();
    }

    //Store Services
    public function store(Request $request){

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

         $service = new Service_Category();
         $service->service_category_name = $request->name;
         $service->status = $request->status;
         $service->remarks = $request->remarks ?? "null";
         $service->create_by = 1;
         $service->create_date = Carbon::Now();
         $service->save();
         return $service;
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
         $service->remarks = $request->remarks ?? "null";
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
