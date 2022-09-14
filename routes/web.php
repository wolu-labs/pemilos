<?php

use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoteController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('dashboard');

        Route::resource('/users', UserController::class)->except('show');

        Route::resource('/candidates', CandidateController::class)->except('show');

        Route::get('/votes', [VoteController::class, 'index'])
            ->name('votes.index');
    });
});
