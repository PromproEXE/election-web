<?php

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

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'getAll')->name('users-get');
        Route::get('/me', 'getMe')->name('users-getme');
        Route::post('/create', 'create')->name('users-create');
        Route::put('/{id}/update', 'update')->name('users-update');
        Route::delete('/{id}/delete', 'delete')->name('users-delete');
    });
