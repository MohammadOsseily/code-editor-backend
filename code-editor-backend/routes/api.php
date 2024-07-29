<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('code_submission',[CodeSubmissionController::class, 'readAll']);
Route::post('code_submission',[CodeSubmissionController::class, 'createCode']);
Route::get('/code_submission/{id}', [CodeSubmissionController::class, 'UserCode']);
Route::delete('/code_submission/{id}', [CodeSubmissionController::class, 'DeleteCode']);