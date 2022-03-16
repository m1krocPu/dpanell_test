<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiProjectController;
use App\Http\Controllers\Api\ApiTodoController;
use App\Http\Controllers\Api\ApiCardItemController;

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

Route::middleware('auth')->group(function () {
	Route::controller(ApiProjectController::class)->prefix('project')->group(function () {
	    Route::get('/', 'data');
	    Route::post('/set', 'set');
	    Route::post('/delete/{id}', 'destroy');
	});
	Route::controller(ApiTodoController::class)->prefix('todo/{project}')->group(function () {
	    Route::get('/', 'data');
	    Route::post('/set', 'set');
	    Route::post('/delete/{id}', 'destroy');
	    Route::prefix('card/{list}')->group(function () {
		    Route::post('/set', 'cardSet');
		    Route::post('/delete/{id}', 'cardDestroy');
		});
		Route::controller(ApiCardItemController::class)->prefix('item/{card}')->group(function () {
	    	Route::get('/', 'data');
		    Route::post('/set', 'set');
		    Route::post('/delete/{id}', 'destroy');
		    Route::post('/checked/{id}', 'checked');
		});
	});
});
