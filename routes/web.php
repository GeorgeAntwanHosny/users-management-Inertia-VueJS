<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return  Inertia::render('Home');
})->name('Home');

Route::get('/users', [UserController::class,'index'])->name('users.index');


Route::middleware(['auth'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/create',[UserController::class,'create']);
        Route::get('/{user}/edit',[UserController::class,'edit']);
        Route::post('/{user}/edit',[UserController::class,'update']);
    });

    Route::post('/auth/logout',[AuthController::class,'destroy'])->name('auth.logout');

});

Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::get('/login',[AuthController::class,'create'])->name('auth.login');
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/registration',[AuthController::class,'viewRegistration']);
    Route::post('/registration',[AuthController::class,'registration']);
});





