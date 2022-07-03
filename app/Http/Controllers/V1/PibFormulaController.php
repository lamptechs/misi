<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PibFormulaResource;
use App\Http\Resources\PibResource;
use App\Models\PibFormula;
use App\Models\Scale;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PibFormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->data = PibFormulaResource::collection(PibFormula::all());
            $this->apiSuccess("PiB Formula Loaded Successfully");
            return $this->apiOutput();

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
                    'name' => 'required',
        
                ]
               );
                
               if ($validator->fails()) {
        
                $this->apiOutput($this->getValidationError($validator), 200);
               }
           
                // foreach($request->question as $question){
                    $formula = new PibFormula();
                    $formula->name = $request->name;
                    $formula->patient_id = $request->patient_id;
                    $formula->type = $request->type;
                    $formula->number = $request->number;
                    $formula->expiration_date = /*$request->expiration_date*/ Carbon::now();
                    // $formula->question_id = $request->question_id;
                    // $formula->question_id = $question;
                    $formula->created_by = $request->user()->id ?? null;
                    $formula->save();
                // }
                // $this->saveScale($request,$formula);

                $this->apiSuccess();
                $this->data = (new PibFormulaResource($formula));
                return $this->apiOutput();
            }catch(Exception $e){
                return $this->apiOutput($this->getError( $e), 500);
            }
    }

    // /**
    //  * Save File Info
    //  */
    // public function saveScale($request, $formula){

    //     // if( !is_array($formula->question_id) ){
    //         $questions = (array) $formula->question_id;
    //         // $scales = (array) $request->scale;
    //     // }
    //     foreach($questions as $question){
    //     // foreach($scales as $scale){
    //         $data = new Scale();
    //         $data->scale = $request->scale;
    //         $data->pib_id = $formula->id;
    //         $data->patient_id = $formula->patient_id;
    //         // $data->question_id = $question;
    //         // $data->question_id = $formula->question_id;
    //         $data->save();     
    //     // } 
    //   } 
      
    // }

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
