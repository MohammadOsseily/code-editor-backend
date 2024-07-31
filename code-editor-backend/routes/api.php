<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
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
    Route::get('/search', [UserController::class, 'search']);

});
Route::middleware('jwt.verify')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('code_submission',[CodeSubmissionController::class, 'readAll']);
Route::post('code_submission',[CodeSubmissionController::class, 'createCode']);
Route::get('/code_submission/{id}', [CodeSubmissionController::class, 'UserCode']);
Route::prefix('chat')->group(function () {
    Route::post("/create", [\App\Http\Controllers\ChatController::class, "create"]);
    Route::post("/get", [\App\Http\Controllers\ChatController::class, "get"]);
});
Route::get('/message/{chat_id}', [MessageController::class, 'index']);
Route::post('/messages/{chat_id}', [MessageController::class, 'store']);
    Route::get('/messages/{chat_id}', [MessageController::class, 'index']);
    Route::post('/messages/{chat_id}', [MessageController::class, 'store']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});


    Route::post('login',[\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/register',[\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/logout',[\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/refresh',[\App\Http\Controllers\AuthController::class, 'refresh']);

    Route::get('code_submission',[CodeSubmissionController::class, 'readAll']);
Route::post('code_submission',[CodeSubmissionController::class, 'createCode']);
Route::get('/code_submission/{id}', [CodeSubmissionController::class, 'UserCode']);
Route::delete('/code_submission/{id}', [CodeSubmissionController::class, 'DeleteCode']);

Route::post('suggestions',[\App\Http\Controllers\CopilotController::class, 'getSuggestions']);

Route::post('/import-users', [UserController::class, 'importUsers']);
