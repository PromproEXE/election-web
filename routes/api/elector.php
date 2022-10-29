<?php

use App\Http\Controllers\ElectorController;
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

Route::prefix('elector')
    ->controller(ElectorController::class)
    ->group(function () {
        Route::get('/', 'getAll')->name('elector-get');
        Route::post('/create', 'create')->name('elector-create');
        Route::get('/{id}', 'getOnce');
        Route::put('/{id}/update', 'update');
        Route::delete('/{id}/delete', 'destroy');
    });
