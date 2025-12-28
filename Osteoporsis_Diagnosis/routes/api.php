<?php

use App\Http\Controllers\API\FullPatientController;
use App\Http\Controllers\API\RadiologyAIController;
use App\Http\Controllers\API\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//public api
Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['auth:api'])->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::post('/searchUsers', 'searchUsers');
        Route::put('/updateProfile', 'updateProfile');
        Route::post('/updatePassword', 'updatePassword');
        Route::get('/showProfile', 'showProfile');
    });

    Route::apiResource('patients', FullPatientController::class);


});
