<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::redirect('/index.html', '/');
Route::get('/segment', [SiteController::class, 'segment'])->name('segment');
Route::get('/segment.html', fn () => redirect()->route('segment', request()->query()));
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/register/success', [RegistrationController::class, 'success'])->name('register.success');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment', [PaymentController::class, 'lookup'])->name('payment.lookup');
Route::get('/payment/{reference_code}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{reference_code}/transaction', [PaymentController::class, 'storeTransaction'])
    ->middleware('throttle:10,1')
    ->name('payment.transaction');
