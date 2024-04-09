<?php

use App\Http\Middleware\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RobiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\agentController;
use App\Http\Controllers\AirtelController;
use App\Http\Controllers\GrameenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustSentController;
use App\Http\Controllers\NetMoneyController;
use App\Http\Controllers\BanglalinkController;
use App\Http\Controllers\CustReciveController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [HomeController::class, 'index'])->name('home');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
->name('logout');

require __DIR__.'/auth.php';


// for admin

Route::middleware(['auth', 'admin'])->prefix("admin/")->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('agent', [NetMoneyController::class, 'index'])
    // ->name('agent.index');

    // agent route satart
    Route::get('agent', [NetMoneyController::class, 'agent'])
    ->name('agent');

    Route::get('agent/{id}', [NetMoneyController::class, 'getTransactions'])->name('agent.transactions');
    Route::post('agent', [NetMoneyController::class, 'store'])->name('addAgentMoney');

    Route::post('agent/update', [agentController::class, 'update'])->name('agent.update');


    // agent route end

    Route::get('customer', [CustomerController::class, 'showAll'])
    ->name('customers');

    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');

    Route::get('customer', [CustomerController::class, 'showAll'])
    ->name('customers');

    Route::get('moneySent', [CustReciveController::class, 'index'])->name('admin.moneySent');
    Route::post('moneySent', [CustSentController::class, 'store'])->name('addMoneyRecive');

    Route::get('moneyCollect', [CustSentController::class, 'index'])->name('admin.moneyCollect');

    // Telecome route start
    Route::get('airtel', [AirtelController::class, 'index'])->name('airtel');
    Route::get('robi', [RobiController::class, 'index'])->name('robi');
    Route::get('grameen', [GrameenController::class, 'index'])->name('grameen');
    Route::get('banglalink', [BanglalinkController::class, 'index'])->name('banglalink');

    Route::post('airtel', [AirtelController::class, 'store'])->name('addAirtel');
    Route::delete('airtel/delete/{id}', [AirtelController::class, 'delete'])->name('deleteAirtel');

    Route::post('robi', [RobiController::class, 'store'])->name('addRobi');
    Route::delete('robi/delete/{id}', [RobiController::class, 'delete'])->name('deleteRobi');


    Route::post('grameen', [GrameenController::class, 'store'])->name('addGrameen');
    Route::delete('grameen/delete/{id}', [GrameenController::class, 'delete'])->name('deleteGrameen');

    Route::post('banglalink', [BanglalinkController::class, 'store'])->name('addBanglalink');
    Route::delete('banglalink/delete/{id}', [BanglalinkController::class, 'delete'])->name('deleteBanglalink');
    // Telecome route end

    // export route start

    Route::get('agent/export', [NetMoneyController::class, 'agentExport'])
    ->name('agent.export');

    Route::get('moneySent/export', [AdminController::class, 'moneySent_Export'])
    ->name('admin.moneySentExport');
    Route::get('moneyCollect/export', [AdminController::class, 'moneyRecive_Export'])
    ->name('admin.moneyReciveExport');


});

// for agent
Route::middleware(['auth', 'agent'])->prefix("agent/")->group(function () {

    Route::get('dashboard', [agentController::class, 'index'])->name('agent.dashboard');

    Route::get('moneySent', [CustReciveController::class, 'agentShow'])->name('agent.moneySent');

    Route::get('pendingMoneySent', [CustReciveController::class, 'pendingMoneySent'])->name('agent.pendingMoneySent');
    Route::post('moneySent', [CustReciveController::class, 'approveMoneySent'])->name('agent.approveMoneySent');

    Route::post('sent', [CustReciveController::class, 'store'])->name('addMoneySent');
    Route::get('{id}', [NetMoneyController::class, 'show'])->name('agent.moneyCollection');


});

// for Customer
Route::middleware(['auth', 'customer'])->group(function () {

    Route::get('dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('moneyCollect', [CustReciveController::class, 'custShow'])->name('customer.moneyCollection');
    Route::post('moneyCollect', [CustReciveController::class, 'requestMoney'])->name('requestMoney');
    Route::post('moneyCollect/update', [CustReciveController::class, 'updateMoney'])->name('updateMoney');

});

// otp route

// Route for sending OTP
// Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('sendOtp');

// Route for OTP verification form
Route::get('/verify-otp', function () {
    return view('auth.otp');
})->name('otp.verify');

// Route for OTP verification
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verifyOtp');




