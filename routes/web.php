<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\getApiDataController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Auth\LoginRegisterController;

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
    return view('welcome');
});



Route::controller(LoginRegisterController::class)->group(function() {

    // Login and Registration
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');

    Route::middleware(['auth.check'])->group(function(){
        // Consumming API 
        Route::get('/apiData',[getApiDataController::class,'apiData']);
        Route::get('/getApiDataList',[getApiDataController::class,'getApiData']);

        // Setup for Razorpay
        Route::get('razorpay',[RazorpayController::class,'index']);
        Route::post('razorpay-payment',[RazorpayController::class,'storePaymentDetails'])->name('razorpay.payment.store');
    });
});

