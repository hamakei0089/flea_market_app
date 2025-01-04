<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
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

/*会員登録*/
Route::get('/register', [RegisteredUserController::class, 'index']);
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

/*ログイン*/
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'authenticated'])->name('login');


/*メール認証*/
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->middleware('auth')->name('verification.resend');

/*user*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [RegisteredUserController::class, 'showProfileForm'])->name('profile.form');
    Route::post('/mypage/profile', [RegisteredUserController::class, 'updateProfile'])->name('profile.update');
});
