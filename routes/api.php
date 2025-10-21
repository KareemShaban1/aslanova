<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Category3dController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryMain3DController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\Product3DController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPartController;
use App\Http\Controllers\ProductTextureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\TextureController;
use App\Http\Controllers\MobileAuthController;
use App\Http\Controllers\EmailPaymentController;
// use App\Http\Controllers\PaypalController;
use App\Http\Controllers\LocationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//admin
// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

// Profile admin
Route::post('/driver/index/profile/{id}/edit', [ProfileController::class, 'updateAdminProfile'])->name('updateadminprofile');
Route::get('/get-all-user', [AdminController::class, 'getAllUsers']);
Route::get('/show-user/{id}', [AdminController::class, 'showUser']);
Route::get('/getAdmin/{id}', [AdminController::class, 'getAdmin']);
Route::post('/editAdmin/{id}', [AdminController::class, 'editAdmin']);
Route::delete('/deleteAdmin/{id}', [AdminController::class, 'deleteAdmin']);
// });

//Customer api

// Route::middleware(['auth'])->group(function () {
// Profile Customer
Route::post('/dashboard/profile/{id}/edit', [ProfileController::class, 'updateProfile'])->name('updateprofile');

// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('locations');
});

// الخاص بالفئة
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::post('/{category}', [CategoryController::class, 'update']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

// الخاص للمنتجات

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::post('/user-search-history', [ProductController::class, 'storeUserSearchHistory']);
    Route::get('/suggested-products', [ProductController::class, 'suggestedProducts']);

    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::post('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
    Route::get('/category/{categoryId}', [ProductController::class, 'showByCategory']);
});

// الخاصة بالطلبات

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrdersController::class, 'index']);
    Route::post('/', [OrdersController::class, 'store']);
    Route::get('/{order}', [OrdersController::class, 'show']);
    Route::put('/{order}', [OrdersController::class, 'update']);
    Route::delete('/{order}', [OrdersController::class, 'destroy']);
});

// الخاص بمنتج الفرعي

Route::prefix('sub-products')->group(function () {
    Route::get('/', [SubProductController::class, 'index']);
    Route::get('/{id}', [SubProductController::class, 'show']);
    Route::post('/', [SubProductController::class, 'store']);
    Route::post('/{id}', [SubProductController::class, 'update']);
    Route::delete('/{id}', [SubProductController::class, 'destroy']);
    // لعرض المنتجات الفرعية لمنتج رئيسي
    Route::get('/subproduct/{productId}', [SubProductController::class, 'index_subproducts']);

});

// الخاص بالعروضات
Route::get('/offers', [OfferController::class, 'index']);
Route::post('/offers', [OfferController::class, 'store']);
Route::get('/offers/{offer}', [OfferController::class, 'show']);
Route::post('/offers/{offer}', [OfferController::class, 'update']);
Route::delete('/offers/{offer}', [OfferController::class, 'destroy']);

// Mobile API
Route::prefix('mobile')->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('sub-products', SubProductController::class);
});
// end Mobile api

// قسم 3d
Route::get('Categorys_3d/{category}/products_3d', [Product3DController::class, 'getProductsByCategory']);

Route::get('category_main_3d/{category}/Categorys_3d', [Category3dController::class, 'showByCategory3d']);

Route::get('materials/{material}/textures', [TextureController::class, 'getTexturesByMaterial']);

Route::apiResource('parts', PartController::class);
Route::apiResource('textures', TextureController::class);
Route::apiResource('materials', MaterialController::class);
Route::apiResource('product_parts', ProductPartController::class);
Route::apiResource('product_textures', ProductTextureController::class);

Route::group(['prefix' => 'products_3d'], function () {
    Route::get('/', [Product3DController::class, 'index']);
    Route::post('/', [Product3DController::class, 'store']);
    Route::get('/{product}', [Product3DController::class, 'show']);
    Route::post('/{product}', [Product3DController::class, 'update']);
    Route::delete('/{product}', [Product3DController::class, 'destroy']);
});

Route::group(['prefix' => 'category_main_3d'], function () {
    Route::get('/', [CategoryMain3DController::class, 'index']);
    Route::post('/', [CategoryMain3DController::class, 'store']);
    Route::get('/{category_main_3d}', [CategoryMain3DController::class, 'show']);
    Route::post('/{category_main_3d}', [CategoryMain3DController::class, 'update']);
    Route::delete('/{category_main_3d}', [CategoryMain3DController::class, 'destroy']);
});

Route::group(['prefix' => 'Categorys_3d'], function () {
    Route::get('/', [Category3dController::class, 'index']);
    Route::post('/', [Category3dController::class, 'store']);
    Route::get('/{category}', [Category3dController::class, 'show']);
    Route::post('/{category}', [Category3dController::class, 'update']);
    Route::delete('/{category}', [Category3dController::class, 'destroy']);
});

// Mobile Auth
Route::post('Mobile/login', [MobileAuthController::class, 'login']);
Route::post('Mobile/register', [MobileAuthController::class, 'register']);
Route::post('Mobile/verify-code', [MobileAuthController::class, 'verifyCode']);

Route::middleware('auth:sanctum')->get('/user-info', [MobileAuthController::class, 'getUserInfo']);
Route::post('Mobile/logout', [MobileAuthController::class, 'logout']);
Route::put('Mobile/user/{id}', [MobileAuthController::class,'update']);



// email payment
Route::get('email-payment', [EmailPaymentController::class, 'index']);
Route::get('paypal-payment', [PaypalController::class, 'index']);

Route::get('user-payments/{id}', [PaypalController::class, 'userPayments']);
Route::get('user-emails/{id}', [EmailPaymentController::class, 'userPayments']);

// *************** Paypal ***************
Route::post('payment', [PaypalController::class, 'paypal'])->name('payment');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');

//route email payment
Route::post('email/payment', [EmailPaymentController::class, 'sendCartDetails']);
Route::post('email/payment/mobile', [EmailPaymentController::class, 'sendCartDetailsMobile']);

// advertisements اعلانات 
Route::apiResource('advertisements', AdvertisementController::class);
Route::post('advertisement/{advertisement}', [AdvertisementController::class, 'update']);

Route::resource('locations', LocationController::class);
Route::post('/paypal/status/{id}', [PaypalController::class, 'updateStatus']);
Route::post('/email/status/{id}', [EmailPaymentController::class, 'updateStatus']);