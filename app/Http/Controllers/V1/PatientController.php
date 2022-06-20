<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Exception;

class PatientController extends Controller
{

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
                'first_name' => 'required',
                'last_name' => 'required',
                // 'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                // 'file' => 'required'
    
            ]
           );
            
            if ($validator->fails()) {
                return response()->json(
                    [$validator->errors()],
                    422
                );
            }


            try{

                DB::beginTransaction();
            if( $request->id == 0 ){
                $data = $this->getModel();
                $data->created_by = 1;
                $data->created_at = Carbon::Now();
                
            }
            //else{
            //     $data = $this->getModel()->find($request->id);
            //     $data->modified_by = 1;
            // }

            // if($request->picture != null)
            // {
            //     $id = uniqid(5);
            //     $imageName = $id.'.'.$request->picture->extension();  
            //     $image = $request->picture->move(public_path('upload'), $imageName);
            //     $imageUrl = url('public/upload/' . $imageName);
            // }

            $data->state_id = $request->state_id;
            $data->country_id = $request->country_id;
            $data->blood_group_id = $request->blood_group_id;
            $data->source = $request->source;
            $data->first_name = $request->first_name;                  
            $data->last_name = $request->last_name;
            // $data->patient_picture_name = $imageName;            
            // $data->patient_picture_location = $imageUrl;            
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->alternet_phone = $request->alternet_phone ?? 0;
            // $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->address = $request->address;
            $data->area = $request->area;
            $data->city = $request->city;
            $data->bsn_number = $request->bsn_number;
            $data->dob_number = $request->dob_number;
            $data->insurance_number = $request->insurance_number;
            $data->emergency_contact = $request->emergency_contact ?? 0;
            $data->age = $request->age;
            $data->gender = $request->gender;
            $data->marital_status = $request->marital_status;
            $data->medical_history = $request->medical_history;
            $data->date_of_birth = Carbon::now();
            $data->occupation = $request->occupation;
            $data->remarks = $request->remarks ?? '';
            $data->password = bcrypt($request->password);
            $data->image_url = $this->addImage($request->picture);
            $data->save();
            $this->saveFileInfo($request, $data);
            
            DB::commit();
                    try{
                        if($request->id == 0){
                            event(new Registered($data));
                        }
                    }catch(Exception $e){
                        //
                    }
            }
            catch(Exception $e){
                return $this->apiOutput($this->getError( $e), 500);
                DB::rollBack();
            }
            // $this->apiSuccess();
            // // $this->data = (new ServiceCategoryResource($service));
            // return $this->apiOutput();
        }catch(Exception $e){
            
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
   


    /**
     * Save File Info
     */
    public function saveFileInfo($request, $patient){
        $data = $patient->file_info;
        if(empty($data)){
            $data = new PatientUpload();            
            $data->created_by = 1;
            $data->created_at = Carbon::Now();
        }
        // else{
        //     $data->updated_by = $request->updated_by;
        // }

        if($request->file != null)
        {
            // $extension = $request->file->extension();
            $id = uniqid(5);
            $fileName = $id.'.'.$request->file->extension();  
            $file = $request->file->move(public_path('upload'), $fileName);
            $fileUrl = url('public/upload/' . $fileName);
        }


        $data->patient_id = $patient->id;
        $data->file_name = $fileName;
        $data->file_url = $fileUrl;
        $data->file_type = $request->file_type;
        $data->status = $request->status;
        $data->remarks = $request->remarks ?? '';
       
        $data->save();
       
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $data = $this->getModel()->find($id);
            $data->delete();
            $this->apiSuccess();
            return $this->apiOutput("Patient Deleted Successfully", 200);
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
        
    }
}
