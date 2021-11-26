<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BannerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {

    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    return "Cache Clear All";
});

//Frontend
Route::get('/', [IndexController::class, 'index'])->name('index');

//Auth
Route::get('user/auth', [IndexController::class, 'userAuth'])->name('user.auth');
Route::post('user/login', [IndexController::class, 'loginSubmit'])->name('login.submit');
Route::post('user/register', [IndexController::class, 'registerSubmit'])->name('register.submit');
Route::get('user/logout', [IndexController::class, 'userLogout'])->name('user.logout');


//Product  category

Route::get('category/{slug}', [IndexController::class, 'productCategory'])->name('product.category');

//Product detail
Route::get('product/{slug}', [IndexController::class, 'productDetail'])->name('product.detail');

//Cart

Route::post('cart/store',[CartController::class,'cartStore'])->name('cart.store');
Route::post('cart/delete',[CartController::class,'cartDelete'])->name('cart.delete');

//End Frontend
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin section
// Admin

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'admin'], function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');

// Banner Section

    Route::resource('banner', BannerController::class);
    Route::post('banner_status', [BannerController::class, 'bannerStatus'])->name('banner.status');

// Category Section

    Route::resource('category', CategoryController::class);
    Route::post('category_status', [CategoryController::class, 'categoryStatus'])->name('category.status');

    Route::post('category/{id}/child', [CategoryController::class, 'getChildByParentID']);
// Brand  Section

    Route::resource('brand', BrandController::class);
    Route::post('brand_status', [BrandController::class, 'brandStatus'])->name('brand.status');

// Product  Section

    Route::resource('product', ProductController::class);
    Route::post('product_status', [ProductController::class, 'productStatus'])->name('product.status');
    Route::post('product_view', [ProductController::class, 'productView'])->name('product.view');

// User Section

    Route::resource('user', UserController::class);
    Route::post('user_status', [UserController::class, 'userStatus'])->name('user.status');
    Route::post('user_view', [UserController::class, 'userView'])->name('user.view');


});

Route::group(['prefix' => 'seller', 'middleware' => 'auth', 'seller'], function () {
    Route::get('/', [AdminController::class, 'admin'])->name('seller');

});

//User Dashboard
Route::group(['prefix' => 'user'], function () {
    Route::get('/dashboard',[IndexController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/order',[IndexController::class, 'userOrder'])->name('user.order');
    Route::get('/address',[IndexController::class, 'userAddress'])->name('user.address');
    Route::get('/account-details',[IndexController::class, 'userAccount'])->name('user.account');

    Route::post('/billing/address/{id}',[IndexController::class, 'billingAddress'])->name('billing.address');
    Route::post('/sipping/address/{id}',[IndexController::class, 'sippingAddress'])->name('sipping.address');

    Route::post('/update/account/{id}',[IndexController::class, 'updateAccount'])->name('account.update');
});
