<?php

use App\Http\Controllers\Auth\PassportAuthController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('roles',RoleController::class)->except('show')->middleware('auth:api');

Route::controller(PassportAuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:api');
});
