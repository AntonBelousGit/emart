<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
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

    //Admin login
    Route::group(['prefix' => 'admin'],function (){
       Route::get('/login', [LoginController::class,'loginForm'])->name('login.form');
       Route::post('/login', [LoginController::class,'login'])->name('admin.login');
    });
    //Auth
    Route::get('user/auth', [IndexController::class, 'userAuth'])->name('user.auth');
    Route::post('user/login', [IndexController::class, 'loginSubmit'])->name('login.submit');
    Route::post('user/register', [IndexController::class, 'registerSubmit'])->name('register.submit');
    Route::get('user/logout', [IndexController::class, 'userLogout'])->name('user.logout');

    //Product  category

    Route::get('category/{slug}', [IndexController::class, 'productCategory'])->name('product.category');

    //Product detail
    Route::get('product/{slug}', [IndexController::class, 'productDetail'])->name('product.detail');
    Route::get('get-product-price/{slug}', [IndexController::class, 'filterPriceWithSize']);

    //Product review

    Route::post('product-review/{slug}',[ProductReviewController::class,'productReview'])->name('product.review');

    //Cart
    Route::get('cart', [CartController::class, 'cart'])->name('cart');
    Route::post('cart/store', [CartController::class, 'cartStore'])->name('cart.store');
    Route::post('cart/delete', [CartController::class, 'cartDelete'])->name('cart.delete');
    Route::post('cart/update', [CartController::class, 'cartUpdate'])->name('cart.update');

    //Coupon section
    Route::post('coupon/add', [CartController::class, 'couponAdd'])->name('coupon.add');

    // Wishlist
    Route::get('wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
    Route::post('wishlist/store', [WishlistController::class, 'wishlistStore'])->name('wishlist.store');
    Route::post('wishlist/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move.cart');
    Route::post('wishlist/delete', [WishlistController::class, 'wishlistDelete'])->name('wishlist.delete');

    //Checkout section
    Route::get('checkout1', [CheckoutController::class, 'checkout1'])->name('checkout1')->middleware('user');
    Route::post('checkout-first',[CheckoutController::class, 'checkout1Store'])->name('checkout1.store');
    Route::post('checkout-second',[CheckoutController::class, 'checkout2Store'])->name('checkout2.store');
    Route::post('checkout-third',[CheckoutController::class, 'checkout3Store'])->name('checkout3.store');
    Route::get('checkout-store',[CheckoutController::class, 'checkoutStore'])->name('checkout.store');
    Route::get('checkout-complete/{order}',[CheckoutController::class, 'complete'])->name('checkout.complete');

    // Shop section
    Route::get('shop',[IndexController::class,'shop'])->name('shop');
    Route::post('shop-filter',[IndexController::class,'shopFilter'])->name('shop.filter');

    // Search product
    Route::get('auto-search',[IndexController::class,'autoSearch'])->name('autosearch');
    Route::get('search',[IndexController::class,'search'])->name('search');

    // End Frontend

    Auth::routes(['register' => false]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Admin section

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
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
    // Product Attribute Section
    Route::post('product-attribute/{id}',[ProductController::class,'addProductAttribute'])->name('product.attribute');
    Route::post('product-attribute-delete/{id}',[ProductController::class,'addProductAttributeDelete'])->name('product.attribute.destroy');
    // User Section

    Route::resource('user', UserController::class);
    Route::post('user_status', [UserController::class, 'userStatus'])->name('user.status');
    Route::post('user_view', [UserController::class, 'userView'])->name('user.view');

    // Coupon Section

    Route::resource('coupon', CouponController::class);
    Route::post('coupon_status', [CouponController::class, 'couponStatus'])->name('coupon.status');

    //Shipping Section
    Route::resource('shipping', ShippingController::class);
    Route::post('shipping_status', [ShippingController::class, 'shippingStatus'])->name('shipping.status');

});

//Seller Dashboard

Route::group(['prefix' => 'seller', 'middleware' => ['auth', 'seller']], function () {
    Route::get('/', [AdminController::class, 'admin'])->name('seller');
});

//User Dashboard
Route::group(['prefix' => 'user'], function () {
    Route::get('/dashboard', [IndexController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/order', [IndexController::class, 'userOrder'])->name('user.order');
    Route::get('/address', [IndexController::class, 'userAddress'])->name('user.address');
    Route::get('/account-details', [IndexController::class, 'userAccount'])->name('user.account');
    Route::post('/billing/address/{id}', [IndexController::class, 'billingAddress'])->name('billing.address');
    Route::post('/sipping/address/{id}', [IndexController::class, 'sippingAddress'])->name('sipping.address');
    Route::post('/update/account/{id}', [IndexController::class, 'updateAccount'])->name('account.update');
});
