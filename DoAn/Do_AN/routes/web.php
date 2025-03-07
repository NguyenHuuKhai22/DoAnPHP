<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VietnamAirlinesController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/vietnam-airlines', [VietnamAirlinesController::class, 'index']);
Route::get('/vietnam-airlines', [VietnamAirlinesController::class, 'index'])->name('vietnam-airlines');

use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');
