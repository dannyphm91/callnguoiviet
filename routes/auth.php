<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//====================Frontend Authentication=========================
Auth::routes(['login' => false, 'register' => false]);

// registration process
Route::controller(FrontendController::class)->group(function () {
    Route::get('/sign-up/account', 'signUp')->name('frontend.signup')->middleware('guest');
    Route::post('customer/register', 'register')->name('customer.register');
    Route::post('/frontend/logout', 'frontendLogout')->name('frontend.logout');
});

// login process
Route::post('/customer/login', [App\Http\Controllers\Frontend\LoginController::class, 'login'])->name('frontend.login')->middleware('auth_logout');

// Customer Reset Password
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot/password', 'forgetPasswordForm')->name('frontend.forgot.password');
    Route::get('/reset-password', 'forgetPasswordForm')->name('frontend.forgot.password');
    Route::post('/customer/password/mail', 'sendResetLinkEmail')->name('customer.password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/password-reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('/customer-password-update', 'reset')->name('customer.password.update');
});

// Social Authentication
Route::controller(SocialLoginController::class)->group(function () {
    Route::get('/auth/{provider}/redirect', 'redirect')->where('provider', 'google|facebook|twitter|linkedin|github|gitlab|bitbucket');
    Route::get('/auth/{provider}/callback', 'callback')->where('provider', 'google|facebook|twitter|linkedin|github|gitlab|bitbucket');
});

//Auth Guard Logout
Route::post('auth-logout', function (Request $request) {
    if ($request->auth === 'customer') {
        Auth::guard('user')->logout();

        return redirect()->route('users.login');
    }
})->name('auth.logout');

Route::get('login', [App\Http\Controllers\Frontend\LoginController::class, 'showLoginForm'])->name('users.login');

//====================Admin Authentication=========================
Route::controller(AdminLoginController::class)->prefix('admin')->group(function () {
    Route::get('/login', 'showLoginForm')->name('login.admin');
    Route::post('/login', 'login')->name('admin.login');
    Route::post('/logout', 'logout')->name('admin.logout');
});
