<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;

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

Route::controller(UserController::class)/*->middleware('auth:api')*/->group(function(){
    Route::get('users','index');
    Route::post('users','store');
    Route::get('users/{user}/edit','edit');
    Route::put('users/{user}','update');
    Route::delete('users/{user}','destroy');
});

Route::controller(PassportAuthController::class)->group(function(){    
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:api');
});
