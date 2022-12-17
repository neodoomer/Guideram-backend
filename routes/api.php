<?php

use App\Http\Controllers\ExpertController;
use App\Http\Controllers\UserController;
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
|gi
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register',[UserController::class,'create']);

Route::post('/expert/register',[ExpertController::class,'create']);

Route::post('/login',[UserController::class,'login']);

Route::get('/logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::get('/expert/{id}',[ExpertController::class,'profile'])->middleware('auth:sanctum');

Route::put('/expert/{id}',[ExpertController::class,'update'])->middleware('auth:sanctum');

Route::get('/experts',[ExpertController::class,'index']);

Route::get('/experts/{type}',[ExpertController::class,'list_by_type']);


Route::get('/experts/{id}',[ExpertController::class,'get']);
