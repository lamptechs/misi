<?php


use App\Http\Controllers\V1\AdminController;
use App\Http\Controllers\V1\AppointmentController;
use App\Http\Controllers\V1\Therapist\TherapistController;
use App\Http\Controllers\V1\Therapist\TherapistDegreeController;
use App\Http\Controllers\V1\Therapist\TherapistServiceController;
use App\Http\Controllers\V1\BloodGroupController;
use App\Http\Controllers\V1\CountryController;
use App\Http\Controllers\V1\OccupationController;
use App\Http\Controllers\V1\PatientController;
use App\Http\Controllers\V1\ServiceCategoryController;
use App\Http\Controllers\V1\ServiceSubCategoryController;
use App\Http\Controllers\V1\StateController;
use App\Http\Controllers\V1\TherapistTypeController;
use App\Http\Controllers\V1\TicketDepartmentController;
use App\Http\Controllers\V1\TicketController;
use App\Http\Controllers\V1\DegreeController;
use App\Http\Controllers\V1\PibFormulaController;
use App\Http\Controllers\V1\QuestionController;
use App\Http\Controllers\V1\QuestionScaleController;
use App\Http\Controllers\V1\Therapist\TherapistScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

/**
 * Admin Login Section
 */
Route::get('admin/login', [AdminController::class, "showLogin"]);
Route::post('admin/login', [AdminController::class, "login"]);
Route::post('admin/logout', [AdminController::class, "logout"]);
/**
 * Protect the Route Throw API Token
 */
Route::middleware(["auth:admin"])->group(function(){
    
    //Patient Create
    Route::prefix('patient')->group(function(){
        Route::get('', [PatientController::class, 'index']);
        Route::get('/show', [PatientController::class, 'show']);
        Route::post('/store', [PatientController::class, 'store']);
        Route::post('/update', [PatientController::class, 'update']);
        Route::post('/delete/{id}', [PatientController::class, 'destroy']);
    });
    
    //Therapist Type
    Route::get('/therapist_type', [TherapistTypeController::class, 'index']);
    Route::post('/therapist_type/store', [TherapistTypeController::class, 'store']);
    Route::post('/therapist_type/update/{id}', [TherapistTypeController::class, 'update']);
    Route::post('/therapist_type/delete/{id}', [TherapistTypeController::class, 'destroy']);

    //Ticket Department
    Route::prefix('ticket_department')->group(function(){
        Route::get('/', [TicketDepartmentController::class, 'index']);
        Route::post('/store', [TicketDepartmentController::class, 'store']);
        Route::post('/update', [TicketDepartmentController::class, 'update']);
        Route::post('/delete/{id}', [TicketDepartmentController::class, 'destroy']);
    });
    

    //Ticket
    Route::prefix('ticket')->group(function(){
        Route::get('/', [TicketController::class, 'index']);
        Route::get('/show', [TicketController::class, 'show']);
        Route::post('/store', [TicketController::class, 'store']);
        Route::post('/update', [TicketController::class, 'update']);
        Route::post('/delete/{id}', [TicketController::class, 'destroy']);
    });
    

    //Therapist Section
    Route::prefix('therapist')->group(function(){
        Route::get('/', [TherapistController::class, 'index']);
        Route::get('/show', [TherapistController::class, 'show']);
        Route::post('/store', [TherapistController::class, 'store']);
        Route::post('/update', [TherapistController::class, 'update']);
        Route::post('/delete/{id}', [TherapistController::class, 'destroy']);
    });
    
    //Therapist Service
    Route::prefix('therapistService')->group(function(){
        Route::get('/', [TherapistServiceController::class, 'index']);
        Route::post('/store', [TherapistServiceController::class, 'store']);
        Route::post('/update', [TherapistServiceController::class, 'update']);
        Route::post('/delete/{id}', [TherapistServiceController::class, 'destroy']);
    });
    

    //Therapist Degree
    Route::prefix('therapist_degree')->group(function(){
        Route::get('/', [TherapistDegreeController::class, 'index']);
        Route::post('/store', [TherapistDegreeController::class, 'store']);
        Route::post('/update/{id}', [TherapistDegreeController::class, 'update']);
        Route::post('/delete/{id}', [TherapistDegreeController::class, 'destroy']);
    });
    

    //Therapist Schedule
    Route::get('/therapist_schedule', [TherapistScheduleController::class, 'index']);
    // Route::post('/therapist_schedule/store', [TherapistScheduleController::class, 'store']);
    // Route::post('/therapist_schedule/update/{id}', [TherapistScheduleController::class, 'update']);
    // Route::post('/therapist_schedule/delete/{id}', [TherapistScheduleController::class, 'destroy']);
    
    //Appointment
    Route::get('/appointment', [AppointmentController::class, 'index']);
    Route::get('/appointment/show', [AppointmentController::class, 'show']);
    Route::post('/appointment/store', [AppointmentController::class, 'store']);
    Route::post('/appointment/update/', [AppointmentController::class, 'update']);
    Route::post('/appointment/delete/{id}', [AppointmentController::class, 'destroy']);

    //Question
    Route::get('/question', [QuestionController::class, 'index']);
    Route::post('/question/store', [QuestionController::class, 'store']);
    // Route::post('/appointment/update/{id}', [AppointmentController::class, 'update']);
    // Route::post('/appointment/delete/{id}', [AppointmentController::class, 'destroy']);

    //Question and scale
    // Route::get('/questionscale', [QuestionScaleController::class, 'index']);
    // Route::post('/questionscale/store', [QuestionScaleController::class, 'store']);
    // Route::post('/appointment/update/{id}', [AppointmentController::class, 'update']);
    // Route::post('/appointment/delete/{id}', [AppointmentController::class, 'destroy']);

    //Pib Formula
    Route::get('/formula', [PibFormulaController::class, 'index']);
    Route::post('/formula/store', [PibFormulaController::class, 'store']);
    // Route::post('/appointment/update/{id}', [AppointmentController::class, 'update']);
    // Route::post('/appointment/delete/{id}', [AppointmentController::class, 'destroy']);

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
    
    //State
    Route::get('/state', [StateController::class, 'index']);
    Route::post('/state/store', [StateController::class, 'store']);
    Route::post('/state/update/{id}', [StateController::class, 'update']);
    Route::post('/state/delete/{id}', [StateController::class, 'destroy']);

    //Country
    Route::get('/country', [CountryController::class, 'index']);
    Route::post('/country/store', [CountryController::class, 'store']);
    Route::post('/country/update/{id}', [CountryController::class, 'update']);
    Route::post('/country/delete/{id}', [CountryController::class, 'destroy']);

    //Degree
    Route::get('/degree', [DegreeController::class, 'index']);
    Route::post('/degree/store', [DegreeController::class, 'store']);
    Route::post('/degree/update/{id}', [DegreeController::class, 'update']);
    Route::post('/degree/delete/{id}', [DegreeController::class, 'destroy']);
    
});


/***********************************************************************************
 * Therapist API Routes
 ***********************************************************************************/
Route::get('therapist/login', [TherapistController::class, "showLogin"]);
Route::post('therapist/login', [TherapistController::class, "login"]);
Route::post('therapist/logout', [TherapistController::class, "logout"]);
/**
 * Therapist Authentication
 */
Route::middleware(["auth:therapist"])->group(function(){
    
});


/***********************************************************************************
 * Patient API Routes
 ***********************************************************************************/
Route::get('patient/login', [PatientController::class, "showLogin"]);
Route::post('patient/login', [PatientController::class, "login"]);
Route::post('patient/logout', [PatientController::class, "logout"]);
/**
 * Patient Authentication
 */
Route::middleware(["auth:patient"])->group(function(){

});


