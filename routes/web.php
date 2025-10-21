<?php

use App\Http\Controllers\EmailPaymentController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PapPalController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\CookieController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
})->name('home');

// تغيير اللغة
Route::get('lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switchLang'])->name('lang.switch');

// حماية المسارات بالمصادقة
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/getuser', [ProfileController::class, 'getUserInfo'])->name('getuser');
    Route::get('/islogged', [MainController::class, 'getLogin'])->name('islogged');
    
    Route::get('/logout', [ProfileController::class, 'destroy'])->name('logout');
});
Route::get('/get-admin', [ProfileController::class, 'getAdminInfo'])->middleware('isDriver')->name('getadmin');

Route::view('/driver/register', 'driver.register');
Route::view('/driver/login', 'driver.login');
Route::view('/driver/index', 'driver.index');

Route::get('auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

Route::middleware(['auth:driver', 'role:admin|employee'])->group(function () {
    Route::get('/user-statistics', [ProfileController::class, 'statistics'])->name('getUsersStatistics');
    Route::get('/get-permissions', function () {
        return Auth::guard('driver')->check() ? Auth::guard('driver')->user()->jsPermissions() : 0;
    });
});


// Route::post('payment', [PapPalController::class, 'payment'])->name('payment');

// Route::get('cancel',[PapPalController::class, 'cancel'])->name('payment.cancel');
// Route::get('payment/success', [PapPalController::class, 'success'])->name('payment.success');

// *************** Paypal ***************
Route::post('payment', [PaypalController::class, 'paypal'])->name('payment');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');

Route::post('/stripe/payment', [StripeController::class, 'createPaymentIntent']);
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
// *************** Cookies ***************

// عرض صفحة الموافقة على الكوكيز
// Route::get('/cookie-consent', [CookieController::class, 'showConsent'])->name('cookie.consent');

// حفظ موافقة المستخدم على الكوكيز
Route::post('/cookie-accept', [CookieController::class, 'acceptCookies'])->name('cookie.accept');

// التحقق من موافقة المستخدم
Route::get('/cookie-check', [CookieController::class, 'checkConsent'])->name('cookie.check');

//route email payment
Route::post('email/payment', [EmailPaymentController::class, 'sendCartDetails']);


use App\Http\Controllers\Auth\RegisteredUserController;

// المسارات الخاصة بالتحقق من البريد الإلكتروني
Route::get('/verify-code2', [RegisteredUserController::class, 'showVerificationForm'])->name('verify-code2');
Route::post('/verify-code', [RegisteredUserController::class, 'verifyCode'])->name('verify.code.submit');


Route::get('/{any}', function () {
    $currentPath = request()->path();

    // قائمة المسارات المستثناة
    $excludedPaths = [
        'driver/logout',
        'driver/register',
        'driver/login',
        'verify-code2',
        'verify-code',
    ];

    if (in_array($currentPath, $excludedPaths)) {
        return redirect($currentPath);
    }

    if (Str::startsWith($currentPath, 'dashboard')) {
        return view('welcome');
    } elseif (Str::startsWith($currentPath, 'driver/index/')) {
        return view('driver.index');
    } else {
        return redirect('/');
    }
})->where('any', '^(?!login|register|logout|driver/login|driver/register|driver/logout|payment|cancel|payment/success|success|paypal|cookie-check|cookie-accept|email/payment|verify-code2|verify-code).*');
// الموجه الخاص بعد عملية الدفع الايميل

// Route::get('/payment/success', function () {
//     return view('payment.success');
// })->name('payment.success');

Route::get('/payment/success/{payment_id}', [EmailPaymentController::class, 'cartDetails'])->name('payment.success');
Route::get('/payment_paypal/success/{payment_id}', [PaypalController::class, 'cartDetails'])->name('payment_paypal.success');

// Route::get('/{any}', function () {
//     $currentPath = request()->path();

//     // تحقق من المسارات التي يتم استثناؤها
//     $excludedPaths = [
//         'driver/logout',
//         'driver/register',
//         'driver/login',
//         'payment',
//         'cancel',
//         'payment/success',
//         'success',
//         'paypal'
//     ];

//     // إذا كانت المسار من المسارات المستثناة، إعادة التوجيه إليه مباشرة
//     if (in_array($currentPath, $excludedPaths)) {
//         return redirect($currentPath);
//     }

//     // التعامل مع المسارات الأخرى
//     if (Str::startsWith($currentPath, 'dashboard')) {
//         return view('welcome');
//     } elseif (Str::startsWith($currentPath, 'driver/index/')) {
//         return view('driver.index');
//     } else {
//         return redirect('/');
//     }
// })->where('any', '^(?!login|register|logout|driver/login|driver/register|driver/logout).*');


// تضمين المسارات المخصصة للمصادقة
require __DIR__ . '/auth.php';
require __DIR__ . '/driver.php';