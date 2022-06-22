<?php

namespace App\Http\Controllers\V1\Therapist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Therapist;
use App\Models\TherapistUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Exception;
use App\Http\Resources\TherapistResource;
use Illuminate\Support\Facades\Hash;

class TherapistController extends Controller
{
    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Therapist();
    }

    /**
     * Show Login
     */
    public function showLogin(Request $request){
        $this->data = [
            "email"     => "required",
            "password"  => "required",
        ];
        $this->apiSuccess("This credentials are required for Login ");
        return $this->apiOutput();
    }

    /**
     * Login
     */
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "email"     => ["required", "email", "exists:therapists,email"],
                "password"  => ["required", "string", "min:4", "max:40"]
            ]); 
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $therapist = $this->getModel()->where("email", $request->email)->first();
            if( !Hash::check($request->password, $therapist->password) ){
                return $this->apiOutput("Sorry! Password Dosen't Match", 401);
            }
            if( !$therapist->status ){
                return $this->apiOutput("Sorry! your account is temporaly blocked", 401);
            }
            // Issueing Access Token
            $this->access_token = $therapist->createToken($request->ip() ?? "therapist_access_token")->plainTextToken;
            $this->apiSuccess("Login Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->data = TherapistResource::collection(Therapist::all());
            return $this->apiOutput("Therapist Loaded Successfully");

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
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

            $data->first_name = $request->first_name;                  
            $data->last_name = $request->last_name;         
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->language = $request->language;
            $data->bsn_number = $request->bsn_number;
            $data->dob_number = $request->dob_number;
            $data->insurance_number = $request->insurance_number;
            $data->emergency_contact = $request->emergency_contact ?? 0;
            $data->gender = $request->gender;
            $data->date_of_birth = /*$request->date_of_birth*/ Carbon::now();
            $data->status = $request->status;
            $data->therapist_type_id = $request->therapist_type_id;
            $data->blood_group_id = $request->blood_group_id;
            $data->state_id = $request->state_id;
            $data->country_id = $request->country_id;
            
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
            $this->apiSuccess();
            $this->data = (new TherapistResource($data));
            return $this->apiOutput();
            
    }

    // Save File Info
    public function saveFileInfo($request, $therapist){
        $data = $therapist->fileInfo;
        if(empty($data)){
            $data = new TherapistUpload();            
            $data->created_at = Carbon::Now();
        }
        // else{
        //     $data->updated_by = $request->updated_by;
        // }

        // if($request->file != null)
        // {
        //     // $extension = $request->file->extension();
        //     $id = uniqid(5);
        //     $fileName = $id.'.'.$request->file->extension();  
        //     $file = $request->file->move(public_path('upload'), $fileName);
        //     $fileUrl = url('public/upload/' . $fileName);
        // }


        $data->therapist_id  = $therapist->id;
        $data->file_name = "null";
        // $data->file_url = $fileUrl;
        // $data->file_url = /*$this->addImage($request->file)*/ "null";
        $data->file_url =  "null";

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
            // Therapist::destroy($id);
            $this->apiSuccess();
            return $this->apiOutput("Therapist Deleted Successfully", 200);
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}