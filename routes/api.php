<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\FavoritingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
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

Route::post('/user/register',[UserController::class,'create']);

Route::post('/expert/register',[ExpertController::class,'create']);

Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/logout',[UserController::class,'logout']);

    Route::get('/expert/{id}',[ExpertController::class,'profile']);

    Route::put('/expert/{id}',[ExpertController::class,'update']);

    Route::get('/experts',[ExpertController::class,'index']);

    Route::get('/experts/{type}',[ExpertController::class,'list_by_type']);

    Route::get('/experts/{id}',[ExpertController::class,'get']);

    Route::get('/expert/free_time/{id}',[ExpertController::class,'list_free']);

    Route::post("/expert/booking/{id}",[ConsultationController::class,'booking']);

    Route::get('/expert/appointments/{id}',[ConsultationController::class,'list_appointments']);

    Route::post('/expert/rate/{id}',[RatingController::class,"create"]);

    Route::post("/expert/favourite/{id}",[FavoritingController::class,"addToFavourite"]);

    Route::get('/expert/is_favourite/{id}',[FavoritingController::class,'is_favorite']);

    Route::get('/user/favorite_list',[FavoritingController::class,'favorite_list']);
});









