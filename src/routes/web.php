<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.detail');

/*会員登録*/
Route::get('/register', [RegisteredUserController::class, 'index']);
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

/*ログイン*/
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login'])->name('login');


/*メール認証*/
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->middleware('auth')->name('verification.resend');

/*user*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

    Route::get('/mypage/profile', [RegisteredUserController::class, 'showProfileForm'])->name('profile.form');
    Route::post('/mypage/profile', [RegisteredUserController::class, 'updateProfile'])->name('profile.update');

    Route::post('/items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/sell', [SellController::class, 'index'])->name('listing.form');
    Route::post('/sell', [SellController::class, 'store'])->name('listing.store');

    Route::post('/items/{item}/favorite', [ItemController::class, 'like'])->name('item.favorite');

    Route::get('/purchase/{item}', [PurchaseController::class, 'index'])->name('purchase.form');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('edit.address');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('update.address');
    Route::post('/checkout/{item}', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

});
