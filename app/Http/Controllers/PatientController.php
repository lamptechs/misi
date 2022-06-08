<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient_info;
use App\Patient_file_upload;
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
        return new Patient_info();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Patient_info::all();
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
                'first_name' => 'required',
                'last_name' => 'required',
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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
            // if( $request->id == 0 ){
                $data = $this->getModel();
                $data->create_by = 1;
                $data->create_date = Carbon::Now();
                
            //  }
            //else{
            //     $data = $this->getModel()->find($request->id);
            //     $data->modified_by = 1;
            // }

            if($request->picture != null)
            {
                $id = uniqid(5);
                $imageName = $id.'.'.$request->picture->extension();  
                $image = $request->picture->move(public_path('upload'), $imageName);
                $imageUrl = url('public/upload/' . $imageName);
            }

            $data->patient_first_name = $request->first_name;                  
            $data->patient_last_name = $request->last_name;
            $data->patient_picture_name = $imageName;            
            $data->patient_picture_location = $imageUrl;            
            $data->patient_email = $request->email;
            $data->patient_phone = $request->phone;
            $data->patient_alternet_phone = $request->alternet_phone ?? 0;
            // $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->patient_address = $request->address;
            $data->patient_area = $request->area;
            $data->patient_city = $request->city;
            $data->patient_country = $request->country;
            $data->bsn_number = $request->bsn_number;
            $data->dob_number = $request->dob_number;
            $data->insurance_number = $request->insurance_number;
            $data->emergency_contact = $request->emergency_contact ?? 0;
            $data->age = $request->age;
            $data->marital_status = $request->marital_status;
            $data->medical_history = $request->medical_history;
            $data->date_of_birth = $request->date_of_birth;
            $data->blood_group = $request->blood_group;
            $data->occupation = $request->occupation;
            $data->admin_remarks = $request->remarks ?? '';
            $data->patient_password = bcrypt($request->password);
            $data->status = $request->status;

            
            $this->saveFileInfo($request, $data);
            $data->save();

            
            
            // $this->saveFirmInfo($request, $data);
            
            
            DB::commit();
                    try{
                        // if($request->id == 0){
                            event(new Registered($data));
                        // }
                    }catch(Exception $e){
                        //
                    }
            }
            catch(Exception $e){
                DB::rollBack();
            }
            return $data;
    }


    /**
     * Save File Info
     */
    public function saveFileInfo($request, $patient){
        $data = $patient->file_info;
        // $data = Patient_file_upload::all();
        if(empty($data)){
            $data = new Patient_file_upload();            
            $data->create_by = 1;
            $data->create_date = Carbon::Now();
        }
        // else{
        //     $data->updated_by = $request->updated_by;
        // }

        


        $data->patient_id = $patient->id;
        $data->file_name = $fileName;
        $data->file_location = $fileUrl;
        $data->file_type = $extension;
        $data->file_remarks = $request->file_remarks ?? '';
        $data->status = $request->status;
        if($request->file != null)
            {
                $extension = $request->file->extension();
                $id = uniqid(5);
                $fileName = $id.'.'.$request->file->extension();  
                $file = $request->file->move(public_path('upload'), $fileName);
                $fileUrl = url('public/upload/' . $fileName);
            }
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
        //
    }
}
