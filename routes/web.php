<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
});

Auth::routes([
    'register' => false, // Routes of Registration
    'reset' => false,    // Routes of Password Reset
    'verify' => false,   // Routes of Email Verification
]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::get('/user/password', [UserController::class, 'password'])->name('user.password');
    Route::post('/user/password', [UserController::class, 'passwordUpdate'])->name('user.password.update');

    Route::get('/company/general', [CompanyController::class, 'general'])->name('company.general');
    Route::post('/company/general', [CompanyController::class, 'generalUpdate'])->name('company.general.update');
    Route::get('/company/social', [CompanyController::class, 'social'])->name('company.social');
    Route::post('/company/social', [CompanyController::class, 'socialUpdate'])->name('company.social.update');
    Route::get('/company/image', [CompanyController::class, 'image'])->name('company.image');
    Route::post('/company/image', [CompanyController::class, 'imageUpdate'])->name('company.image.update');
    Route::get('/company/other', [CompanyController::class, 'other'])->name('company.other');
    Route::post('/company/other', [CompanyController::class, 'otherUpdate'])->name('company.other.update');

    Route::resource('user', UserController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('product', ProductController::class);
    Route::post('order/{order}/set', [OrderController::class, 'set'])->name('order.set');
    Route::resource('order', OrderController::class);
});
