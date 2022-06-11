<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\Therapist\TherapistServiceController;
use App\Http\Controllers\Therapist\TherapistController;
use App\Http\Controllers\ServiceSubCategoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\TherapistTypeController;
use App\Http\Controllers\TicketDepartmentController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Therapist\TherapistDegreeController;

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

//Therapist Create
Route::get('/therapist', [TherapistController::class, 'index']);
Route::post('/therapist/store', [TherapistController::class, 'store']);
Route::post('/therapist/update/{id}', [TherapistController::class, 'update']);
Route::post('/therapist/delete/{id}', [TherapistController::class, 'destroy']);

//Patient Create
Route::get('/patient', [PatientController::class, 'index']);
Route::post('/patient/store', [PatientController::class, 'store']);
Route::post('/patient/update/{id}', [PatientController::class, 'update']);
Route::post('/patient/delete/{id}', [PatientController::class, 'destroy']);

//Occupation
Route::get('/occupation', [OccupationController::class, 'index']);
Route::post('/occupation/store', [OccupationController::class, 'store']);
Route::post('/occupation/update/{id}', [OccupationController::class, 'update']);
Route::post('/occupation/delete/{id}', [OccupationController::class, 'destroy']);

//Blood Group
Route::get('/blood_group', [BloodGroupController::class, 'index']);
Route::post('/blood_group/store', [BloodGroupController::class, 'store']);
Route::post('/blood_group/update/{id}', [BloodGroupController::class, 'update']);
Route::post('/blood_group/delete/{id}', [BloodGroupController::class, 'destroy']);

//Blood Group
Route::get('/therapist_type', [TherapistTypeController::class, 'index']);
Route::post('/therapist_type/store', [TherapistTypeController::class, 'store']);
Route::post('/therapist_type/update/{id}', [TherapistTypeController::class, 'update']);
Route::post('/therapist_type/delete/{id}', [TherapistTypeController::class, 'destroy']);

//Ticket Department
Route::get('/ticket_department', [TicketDepartmentController::class, 'index']);
Route::post('/ticket_department/store', [TicketDepartmentController::class, 'store']);
Route::post('/ticket_department/update/{id}', [TicketDepartmentController::class, 'update']);
Route::post('/ticket_department/delete/{id}', [TicketDepartmentController::class, 'destroy']);

//State/City
Route::get('/state_city', [StateController::class, 'index']);
Route::post('/state_city/store', [StateController::class, 'store']);
Route::post('/state_city/update/{id}', [StateController::class, 'update']);
Route::post('/state_city/delete/{id}', [StateController::class, 'destroy']);

//Country
Route::get('/country', [CountryController::class, 'index']);
Route::post('/country/store', [CountryController::class, 'store']);
Route::post('/country/update/{id}', [CountryController::class, 'update']);
Route::post('/country/delete/{id}', [CountryController::class, 'destroy']);

//Therapist Degree
Route::get('/degree', [TherapistDegreeController::class, 'index']);
Route::post('/degree/store', [TherapistDegreeController::class, 'store']);
Route::post('/degree/update/{id}', [TherapistDegreeController::class, 'update']);
Route::post('/degree/delete/{id}', [TherapistDegreeController::class, 'destroy']);