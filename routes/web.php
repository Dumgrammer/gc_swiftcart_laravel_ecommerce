<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
//
Auth::routes([
    'verify'=>true
]);


Route::controller(App\Http\Controllers\Frontend\FrontendController::class)->group(function () {
    Route::get('/','index');
    Route::get('/collections','categories');
    Route::get('/collections/{category_slug}','products');
    Route::get('/collections/{category_slug}/{product_slug}','productView');
    Route::get('/new-arrivals','newArrivals');
    Route::get('/featured-products','featuredProducts');
    Route::get('search','searchProducts');
});



Route::middleware(['auth'])->group(function(){

    Route::get('wishlist', [App\Http\Controllers\Frontend\WishlistController::class,'index']);
    Route::get('cart', [App\Http\Controllers\Frontend\CartController::class,'index']);
    Route::get('checkout', [App\Http\Controllers\Frontend\CheckoutController::class,'index']);
    Route::get('orders', [App\Http\Controllers\Frontend\OrderController::class,'index']);
    Route::get('orders/{orderId}', [App\Http\Controllers\Frontend\OrderController::class,'show']);

    Route::get('profile',[App\Http\Controllers\Frontend\UserController::class,'index']);
    Route::post('profile',[App\Http\Controllers\Frontend\UserController::class,'updateUserDeitails']);
    Route::get('change-password',[App\Http\Controllers\Frontend\UserController::class,'createPassword']);
    Route::post('change-password', [App\Http\Controllers\Frontend\UserController::class, 'changePassword']);
});

Route::get('thank-you',[App\Http\Controllers\Frontend\FrontendController::class,'arigathanksgozaimuch']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){

    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::controller(App\Http\Controllers\Admin\SettingController::class)->group(function () {
        Route::get('settings','index');
        Route::post('settings', 'store');
    });
    Route::controller(App\Http\Controllers\Admin\SliderController::class)->group(function () {
        Route::get('sliders','index');
        Route::get('sliders/create', 'create');
        Route::post('sliders/create', 'store');
        Route::get('sliders/{slider}/edit', 'edit');
        Route::put('sliders/{slider}','update');
        Route::get('sliders/{slider}/delete','destroy');
    });
    
    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/create', 'create');
        Route::post('/category', 'store');
        Route::get('/category/{category}/edit', 'edit');
        Route::put('/category/{category}', 'update');
    });

    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/create', 'create');
        Route::post('/products','store');
        Route::get('/products/{product}/edit','edit');
        Route::put('/products/{product}', 'update');
        Route::get('/products/{product_id}/delete','destroy');
        Route::get('product-image/{product_image_id}/delete','destroyImage');

        Route::post('product-color/{prod_color_id}','updateProductColorQty');
        Route::get('product-color/{prod_color_id}/delete','deleteProductColor');
    });

    Route::get('/brands',App\Http\Livewire\Admin\Brand\Index::class);
    Route::controller(App\Http\Controllers\Admin\ColorController::class)->group(function () {
        Route::get('/colors', 'index');
        Route::get('/colors/create', 'create');
        Route::post('/colors/create','store');
        Route::get('/colors/{color}/edit','edit');
        Route::put('/colors/{color_id}', 'update');
        Route::get('/colors/{color_id}/delete','destroy');
    });

    Route::controller(App\Http\Controllers\Admin\OrderController::class)->group(function () {
        Route::get('/orders', 'index');
        Route::get('orders/{orderId}', 'show');
        Route::put('orders/{orderId}', 'updateOrderStatus');

        Route::get('invoice/{orderId}', 'viewInvoice');
        Route::get('invoice/{orderId}/generate', 'generateInvoice');
        Route::get('invoice/{$orderId}/mail', 'mailInvoice');
    });

    Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/create', 'create');
        Route::post('/users', 'store');
        Route::get('/users/{user_id}/edit', 'edit');
        Route::put('/users/{user_id}', 'update');
        Route::get('/users/{user_id}/delete', 'destroy');
    });

});