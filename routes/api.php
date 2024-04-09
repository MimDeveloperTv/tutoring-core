<?php

use App\Http\Controllers\Auth\ConnectionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\User\PatientController;
use App\Http\Controllers\User\OperatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalFormController;
use App\Http\Controllers\User\UserPatientController;
use App\Http\Controllers\User\UserOperatorController;
use App\Http\Controllers\Patient\MedicalHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentOccurredController;

Route::apiResource('patients', PatientController::class);
Route::get('user/{id}/patient',[UserPatientController::class,'show']);
Route::post('user/{id}/patient',[UserPatientController::class,'store']);
Route::get('user/{id}/operator',[UserOperatorController::class,'show']);
Route::post('user/{id}/operator',[UserOperatorController::class,'store']);

Route::get('/personnel',[PersonnelController::class,'index']);
Route::get('/personnel/{id}',[PersonnelController::class,'show']);

Route::get('reserves',[AppointmentController::class,'index']);
Route::get('reserves/{id}',[AppointmentController::class,'show']);
Route::post('reserves',[AppointmentController::class,'store']);
Route::post('reserves/slots',[AppointmentController::class,'slots']);
Route::patch('reserves/{id}/payment-status',[AppointmentController::class,'updatePaymentStatus']);
Route::patch('reserves/{id}/status',[AppointmentController::class,'updateStatus']);
Route::post('reserves/notification',[AppointmentOccurredController::class,'newAppointment']);

Route::get('operators',[OperatorController::class,'index']);
Route::get('operators/{id}',[OperatorController::class,'show']);
Route::post('operators',[OperatorController::class,'store']);

Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/get-domain-connection', [ConnectionController::class,'getConnection']);
Route::get('dashboard',[DashboardController::class,'index']);

/* -- Deprecate And Remove Soon ------------------- */
//Route::apiResource('medical-history', MedicalHistoryController::class);
//Route::get('planning-errors',[\App\Http\Controllers\Planning\PlanningController::class,'getPlanningErrors']);
//Route::get('surgery-form-data',[\App\Http\Controllers\Surgery\SurgeryController::class,'getSurgeryFormData']);
//Route::get('diagnosis-data',[\App\Http\Controllers\DiagnosisController::class,'index']);
//Route::get('medical-forms',[MedicalFormController::class,'index']);
//Route::get('medical-forms/{id}',[MedicalFormController::class,'show']);
//Route::put('medical-forms/{id}',[MedicalFormController::class,'submit']);
//Route::patch('medical-forms/{id}',[MedicalFormController::class,'draft']);
//Route::post('upload-medicine-files',[\App\Http\Controllers\Imaging\FileUploaderController::class,'store']);

