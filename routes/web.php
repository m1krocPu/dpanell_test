<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login',  [AuthController::class, 'index'])->name("login");
Route::post('login', [AuthController::class, 'doLogin']);
Route::middleware("auth")->group(function () {
    Route::get('logout', [AuthController::class, 'doLogout'] );
    Route::get('change_pass', [AuthController::class,'changePasswordIndex']);
    Route::post('change_pass', [AuthController::class,'changePassword']);

	Route::get('/', [DashboardController::class, 'index'] );

	Route::controller(TodoController::class)->prefix('todo')->group(function () {
	    Route::get('/', 'index');
	    Route::get('/{id}', 'list');
	});

});
