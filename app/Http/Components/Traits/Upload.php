<?php

namespace App\Http\Components\Traits;

/**
 *
 * @author Sm Shahjalal Shaju
 */

use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait Upload{
    /*
     * Define Directories
     */
    protected  $patient_uploads = "storage/uploads/patient/";
    protected  $therapist_uploads = "storage/uploads/therapist/";
    protected  $admin_profile = "storage/uploads/admin/profile";
    protected  $logo_dir = "storage/uploads/logo";
    protected  $others_dir = "storage/uploads/others";

    /*
     * ---------------------------------------------
     * Check the Derectory If exists or Not
     * ---------------------------------------------
     */
    protected function CheckDir($dir){
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        
        if(!file_exists($dir.'index.php')){
            $file = fopen($dir.'index.php','w');
            fwrite($file," <?php \n /* \n Unauthorize Access \n @Developer: Sm Shahjalal Shaju \n Email: shajushahjalal@gmail.com \n */ ");
            fclose($file);
        }
    }
    
    /*
     * ---------------------------------------------
     * Check the file If exists then Delete the file
     * ---------------------------------------------
     */
    protected function RemoveFile($filePath) {
        if(file_exists($filePath)){
            try{
                unlink($filePath);
            }catch(Exception $e){
                // Exception
            }
        }
    }
    
    /*
     * ---------------------------------------------
     * Upload an Image
     * Change Image height and width
     * Send the null value in height or width to keep 
     * the Image Orginal Ratio.
     * ---------------------------------------------
     */
    protected function uploadImage($request, $fileName, $dir, $width = null, $height =  null, $oldFile = ""){
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile);
        
        ini_set('memory_limit', '1024M');
        $path_arr = [];

        if(is_array($request->$fileName) ){
            foreach($request->$fileName as $key => $file){
                $image = $request->file($fileName)[$key];
                $filename = $fileName.'_'.time().$key.'.'.$image->getClientOriginalExtension();
                $path = $dir.$filename;

                if( empty($height) && empty($width)){
                    Image::make($image)->save($path);
                }
                elseif( empty($height) && !empty($width) ){
                    Image::make($image)->resize($width,null,function($constant){
                        $constant->aspectRatio();
                    })->save($path);
                }        
                elseif( !empty($height) && empty($width) ){
                    Image::make($image)->resize(null,$height,function($constant){
                        $constant->aspectRatio();
                    })->save($path);
                }
                else{
                    Image::make($image)->resize($width,$height)->save($path);
                }
                $path_arr[] = $path;
            }
        }else{
            $image = $request->file($fileName);
            $filename = $fileName.'_'.time().'.'.$image->getClientOriginalExtension();
            $path = $dir.$filename;
           
            if( empty($height) && empty($width)){
                Image::make($image)->save($path);
            }
            elseif( empty($height) && !empty($width) ){
                Image::make($image)->resize($width,null,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }        
            elseif( !empty($height) && empty($width) ){
                Image::make($image)->resize(null,$height,function($constant){
                    $constant->aspectRatio();
                })->save($path);
            }
            else{
                Image::make($image)->resize($width,$height)->save($path);
            }
            $path_arr   = $path;
        }
        return $path_arr;
    }

    // Upload Image
    // protected function addImage($file){
    //     return Storage::disk("public")->putFile("upload", $file);
    // }

    
    /*
     * ---------------------------------------------
     * Upload any Kind of file
     * ---------------------------------------------
     */
    protected function UploadAnyFile($request,$fileName,$dir,$oldFile){
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        ini_set('memory_limit', '1024M');
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile); 
        $file = $request->file($fileName);  
        $Newfilename = 'video_'.time().'.mp4';
        $file->move($dir,$Newfilename); 
        return $dir.$Newfilename;
    }
    
    /**
     * ------------------------------------------------------------
     * Upload Multiple Image
     * ------------------------------------------------------------
     */
    protected function UploadMultipleImage($request,$fileName,$dir,$width,$height) {
        if($request->hasfile($fileName))
        {
            $this->CheckDir($dir);
            ini_set('memory_limit', '1024M');
            $count = 0;
            $allImage= [];
            foreach($request->file($fileName) as $image)
            {
                $filename = $fileName.$count.time().'.'.$image->getClientOriginalExtension();
                $path = $dir.$filename;
                Image::make($image)->resize($width,$height)->save($path);
                $allImage[$count] = $path;
                $count++;
            }
            return $allImage;
        }
    }
}