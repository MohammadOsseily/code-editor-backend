<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CodeSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

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
Route::prefix('user')->group(function () {

    Route::post("/create", [\App\Http\Controllers\UserController::class, "create"]);
    Route::post("/get", [\App\Http\Controllers\UserController::class, "show"]);
    Route::post("/getone/{id}", [\App\Http\Controllers\UserController::class, "getOne"]);
    Route::post("/update/{id}", [\App\Http\Controllers\UserController::class, "update"]);
    Route::post("/delete/{id}", [\App\Http\Controllers\UserController::class, "delete"]);

});
Route::prefix('chat')->group(function () {

    Route::post("/create", [\App\Http\Controllers\ChatController::class, "create"]);
    Route::post("/get", [\App\Http\Controllers\ChatController::class, "get"]);

});
Route::prefix('message')->group(function () {

    Route::post("/create/{chat_id}", [\App\Http\Controllers\MessageController::class, "create"]);
    Route::post("/get/{chat_id}", [\App\Http\Controllers\MessageController::class, "get"]);

});


    Route::post('login',[\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/register',[\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/logout',[\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/refresh',[\App\Http\Controllers\AuthController::class, 'refresh']);

    Route::get('code_submission',[CodeSubmissionController::class, 'readAll']);
Route::post('code_submission',[CodeSubmissionController::class, 'createCode']);
Route::get('/code_submission/{id}', [CodeSubmissionController::class, 'UserCode']);
Route::delete('/code_submission/{id}', [CodeSubmissionController::class, 'DeleteCode']);