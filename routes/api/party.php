<?php

use App\Http\Controllers\PartyController;
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

Route::prefix('party')
    ->controller(PartyController::class)
    ->group(function () {
        Route::get('/', 'getAll')->name('party-get');
        Route::post('/create', 'create')->name('party-create');
        Route::put('/{id}/update', 'update')->name('party-update');
        Route::delete('/{id}/delete', 'delete')->name('party-delete');
    });
