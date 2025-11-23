<?php

use App\Http\Controllers\API\UserController;
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
        Route::post('/addUser', 'addUser');
        Route::delete('/delete-user/{id}', 'deleteUser');
        Route::delete('/force-delete-user/{id}', 'forceDeleteUser');
        Route::get('/show-deleted-users', 'showDeletedUsers');
        Route::post('/restore-user/{id}', 'restoreUser');
        Route::get('/all-users', 'getAllUsers');
        Route::put('/update-user/{id}', 'updateUser');
        Route::post('/logout', 'logout');
        Route::post('/searchUsers', 'searchUsers');
        Route::put('/updateProfile', 'updateProfile');
        Route::post('/updatePassword', 'updatePassword');
        Route::get('/showProfile', 'showProfile');
    });
});
