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
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register',[UserController::class,'create']);

Route::post('/expert/register',[ExpertController::class,'create']);

//login must work for both to mohamd i am sorry for not doing it )':
Route::post('/user/login',[UserController::class,'login']);
