<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VietnamAirlinesController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

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
// Flight search and results
Route::get('/search', [FlightController::class, 'showSearchForm'])->name('flights.search');
Route::post('/search-results', [FlightController::class, 'searchFlights'])->name('flights.results');

// Booking process
Route::get('/select-flight/{id}', [BookingController::class, 'selectFlight'])->name('booking.select');
Route::post('/passenger-info', [BookingController::class, 'passengerInfo'])->name('booking.passenger');
Route::match(['get', 'post'], '/review-booking', [BookingController::class, 'reviewBooking'])->name('booking.review');

// Payment
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/booking-confirmation/{id}', [PaymentController::class, 'showConfirmation'])->name('booking.confirmation');

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');
