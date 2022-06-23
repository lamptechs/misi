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
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new User();
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
                "email"     => ["required", "email", "exists:users,email"],
                "password"  => ["required", "string", "min:4", "max:40"]
            ]); 
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $patient = $this->getModel()->where("email", $request->email)->first();
            if( !Hash::check($request->password, $patient->password) ){
                return $this->apiOutput("Sorry! Password Dosen't Match", 401);
            }
            if( !$patient->status ){
                return $this->apiOutput("Sorry! your account is temporaly blocked", 401);
            }
            // Issueing Access Token
            $this->access_token = $patient->createToken($request->ip() ?? "patient_access_token")->plainTextToken;
            $this->apiSuccess("Login Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
    public function logout(Request $request){
        
        // Session::flush('access_token');
        // // $user = $request->user();
        // // $request->user()->access_token->delete();
        // $this->apiSuccess("Logout Successfull");
        // return $this->apiOutput();
        $user = auth('sanctum')->user();
        // 
        foreach ($user->tokens as $token) {
            $token->delete();
       }
       $this->apiSuccess("Logout Successfull");
       return $this->apiOutput();
   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->data = UserResource::collection(User::all());
            return $this->apiOutput("Patient Loaded Successfully");

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
                return $this->apiOutput($this->getValidationError($validator), 400);
            }

            try{

                DB::beginTransaction();
                $data = $this->getModel();
                // $data->created_at = Carbon::Now();
                $data->created_by = $request->user()->id ?? null;

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
                if($request->hasFile('picture')){
                    $data->image_url = $this->addImage($request->picture);
                }
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
            $this->data = (new UserResource($data));
            return $this->apiOutput();
        }catch(Exception $e){
            
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
   


    /**
     * Save File Info
     */
    public function saveFileInfo($request, $patient){
        $data = $patient->fileInfo;
        if(empty($data)){
            $data = new PatientUpload();            
            $data->created_by = $request->user()->id;
        }

        // if( $request->hasFile('file'))
        // {
        //     $fileUrl = $this->UploadMultipleImage($request->file);
        // }


        $data->patient_id = $patient->id;
        $data->file_name = $request->file_name ?? "Paitent Upload";
        $data->file_url = $this->uploadImage($request,'file',$this->advisor_image,null,null);
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
