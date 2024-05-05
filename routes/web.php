<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'login_view'])->name('login');
Route::get('register', [AuthController::class, 'register_view'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login_post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Route::get('user', [UserControlller::class, 'index'])->name('user.index');
    // Route::post('update_role/{user}', [UserControlller::class, 'updateRole'])->name('user.role');
    Route::get('transactions', [TransactionController::class , 'index'])->name('transactions.index');
    Route::get('deposit', [TransactionController::class , 'deposit'])->name('transactions.deposit');
    Route::post('deposit', [TransactionController::class , 'addDeposit'])->name('transactions.add_deposit');
    Route::get('withdraw', [TransactionController::class , 'withdraw'])->name('transactions.withdraw');
    Route::post('withdraw', [TransactionController::class , 'makeWithdraw'])->name('transactions.make_ithdraw');
});
