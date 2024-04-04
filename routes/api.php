<?php

use App\Http\Controllers\Auth\ConnectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\User\PatientController;
use App\Http\Controllers\User\OperatorController;
use App\Http\Resources\OperatorCollection;
use App\Http\Resources\PatientResource;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalFormController;
use App\Http\Controllers\User\UserPatientController;
use App\Http\Controllers\User\UserOperatorController;
use App\Http\Controllers\Patient\MedicalHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([], function(){
   Route::apiResource('medical-history', MedicalHistoryController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/get-domain-connection', [ConnectionController::class,'getConnection']);

Route::get('dashboard',[DashboardController::class,'index']);

Route::apiResource('patients', PatientController::class);

Route::get('/personnel',[PersonnelController::class,'index']);
Route::get('/personnel/{id}',[PersonnelController::class,'show']);


Route::get('user/{id}/patient',[UserPatientController::class,'show']);
Route::post('user/{id}/patient',[UserPatientController::class,'store']);

Route::get('user/{id}/operator',[UserOperatorController::class,'show']);
Route::post('user/{id}/operator',[UserOperatorController::class,'store']);

Route::get('appointments',[AppointmentController::class,'index']);
Route::patch('appointments/{id}/payment-status',[AppointmentController::class,'updatePaymentStatus']);
Route::patch('appointments/{id}/status',[AppointmentController::class,'updateStatus']);

Route::group(['prefix' => 'operators'], function () {
    Route::get('/', [OperatorController::class, 'index']);
    Route::post('/', [OperatorController::class, 'store']);
    Route::get('/{id}', [OperatorController::class, 'show']);
});

Route::get('planning-errors',[\App\Http\Controllers\Planning\PlanningController::class,'getPlanningErrors']);
Route::get('surgery-form-data',[\App\Http\Controllers\Surgery\SurgeryController::class,'getSurgeryFormData']);
Route::get('diagnosis-data',[\App\Http\Controllers\DiagnosisController::class,'index']);

Route::post('new-reservation-occurred',[\App\Http\Controllers\AppointmentOccurredController::class,'newAppointment']);

Route::get('medical-forms',[MedicalFormController::class,'index']);
Route::get('medical-forms/{id}',[MedicalFormController::class,'show']);
Route::put('medical-forms/{id}',[MedicalFormController::class,'submit']);
Route::patch('medical-forms/{id}',[MedicalFormController::class,'draft']);
Route::post('upload-medicine-files',[\App\Http\Controllers\Imaging\FileUploaderController::class,'store']);

//  Route::post('operators',function(Request $request){
//     $user = User::create([
//         'national_code' => $request->national_code,
//         'email' => $request->email,
//         'mobile' => $request->mobile,
//         'password' => $request->password,
//     ]);

//      $operator = $user->resource()->create([
//          'firstname' => $request->firstname,
//          'lastname' => $request->lastname
//      ]);
//      new OperatorCreatedEvent($operator->id);
//      return $operator;
//  });

