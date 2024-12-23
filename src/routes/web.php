<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemController;

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
Route::get('/', [ItemController::class, 'index']);
Route::view('/register', 'auth.register')->name('register');
Route::view('/login', 'auth.login')->name('login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/listing', [ItemController::class, 'list_index']);
    Route::post('/listing', [ItemController::class, 'list']);
    Route::get('/purchase', [ItemController::class, 'purchase_index']);
    Route::post('/purchase', [ItemController::class, 'purchase']);
});

Route::view('/register', 'auth.register')->name('register');
Route::view('/login', 'auth.login')->name('login');
Route::view('/profile', 'auth.profile')->name('profile.edit');
Route::view('/password', 'auth.password')->name('password.edit');
Route::view('/reset-password/{token}', 'auth.reset-password')->name('password.reset');