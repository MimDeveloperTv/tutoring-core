<?php

use App\Http\Controllers\Global\AdminController;
use App\Http\Controllers\Global\DomainRegisterController;
use Illuminate\Support\Facades\Route;


Route::post('register-new-domain', [DomainRegisterController::class, 'register']);
Route::post('migrate-domain-db', [DomainRegisterController::class, 'migrate']);
Route::post('admins', [AdminController::class, 'store']);
