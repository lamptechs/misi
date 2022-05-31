<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Therapist\ServiceCategoryController;
use App\Http\Controllers\Therapist\TherapistServiceController;
use App\Http\Controllers\Therapist\ServiceSubCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Service Category
Route::get('/service', [ServiceCategoryController::class, 'index']);
Route::post('/service/store', [ServiceCategoryController::class, 'store']);
Route::post('/service/update/{id}', [ServiceCategoryController::class, 'update']);
Route::post('/service/delete/{id}', [ServiceCategoryController::class, 'destroy']);

//Service SubCategory
Route::get('/subservice', [ServiceSubCategoryController::class, 'index']);
Route::post('/subservice/store', [ServiceSubCategoryController::class, 'store']);
Route::post('/subservice/update/{id}', [ServiceSubCategoryController::class, 'update']);
Route::post('/subservice/delete/{id}', [ServiceSubCategoryController::class, 'destroy']);

//Therapist Service
Route::get('/therapistService', [TherapistServiceController::class, 'index']);
Route::post('/therapistService/store', [TherapistServiceController::class, 'store']);
Route::post('/therapistService/update/{id}', [TherapistServiceController::class, 'update']);
Route::post('/therapistService/delete/{id}', [TherapistServiceController::class, 'destroy']);