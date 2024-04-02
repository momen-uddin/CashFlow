<?php

use App\Http\Middleware\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\agentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustSentController;
use App\Http\Controllers\NetMoneyController;
use App\Http\Controllers\CustReciveController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('agent/export', [NetMoneyController::class, 'agentExport'])
    ->name('agent.export');

    Route::get('agent/{id}', [NetMoneyController::class, 'getTransactions'])->name('agent.transactions');
    Route::post('agent', [NetMoneyController::class, 'store'])->name('addAgentMoney');

    // agent route end

    Route::get('customer', [CustomerController::class, 'showAll'])
    ->name('customers');


    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');


    Route::get('moneySent', [CustReciveController::class, 'index'])->name('admin.moneySent');
    Route::post('moneySent', [CustSentController::class, 'store'])->name('addMoneyRecive');

    Route::get('moneyCollect', [CustSentController::class, 'index'])->name('admin.moneyCollect');

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



