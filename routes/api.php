<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/news',[NewsController::class,'searchAndFilterNews']);

Route::get('/news/users/preferences',[NewsController::class,'getUserPreference']);

Route::get('/news/users/preferences/{pref_id}',[NewsController::class,'getAUserPreference']);

Route::post('/news/adds/preferences',[NewsController::class,'addUserPreference']);

Route::delete('/news/removes/preferences',[NewsController::class,'removeUserPreference']);
