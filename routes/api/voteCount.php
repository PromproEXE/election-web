<?php

use App\Http\Controllers\VoteCountController;
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

Route::prefix('vote_count')
    ->controller(VoteCountController::class)
    ->group(function () {
        Route::get('/', 'getAll')->name('vote_count-get');
        Route::get('/count', 'getVoteCount')->name('vote_count-get-count');
        Route::post('/create', 'create')->name('vote_count-create');
        Route::put('/{id}/update', 'edit')->name('vote_count-update');
        Route::delete('/{id}/delete', 'delete')->name('vote_count-delete');
    });
