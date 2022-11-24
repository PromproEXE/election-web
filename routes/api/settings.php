<?php

use App\Http\Controllers\SettingsController;
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

Route::prefix('settings')
    ->controller(SettingsController::class)
    ->group(function () {
        Route::get('/', 'getAllSettings')->name('settings-get');
        Route::post('/create', 'create')->name('settings-create');
        Route::put('/{id}/update', 'edit')->name('settings-update');
        Route::delete('/{id}/delete', 'delete')->name('settings-delete');
    });
