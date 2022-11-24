<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::inertia('/', 'Index')->name('index');
    Route::prefix('/register-elector')->group(function () {
        Route::inertia('/', 'RegisterElector')->name('register-elector');
        Route::inertia('/reg', 'registerElector/register')->name('register-elector-reg');
        Route::inertia('/edit', 'registerElector/edit')->name('register-elector-edit');
        Route::inertia('/add', 'registerElector/add')->name('register-elector-add');
    });

    Route::prefix('/election')->group(function () {
        Route::inertia('/', 'election/election')->name('election');
    });

    Route::prefix('/users')->group(function () {
        Route::inertia('/', 'users/users')->name('users');
    });

    Route::prefix('/settings')->group(function () {
        Route::inertia('/party', 'settings/party')->name('party');
        Route::inertia('/system', 'settings/system')->name('system');
    });


    Route::prefix('/monitor')->group(function () {
        Route::inertia('/', 'monitor/monitor')->name('monitor');
    });
});
