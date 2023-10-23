<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Front routes

Route::get('/',[FrontController::class,'index'])->name('front.home');

Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class,'index'])->name('front.shop');

Route::get('/product/{slug}',[ShopController::class,'product'])->name('front.product');

// email routes

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    Auth::user()->sendEmailVerificationNotification();

    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::post('/email/verification-notification', function (Request $request) {
    Auth::user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect()->route('account.profile');
})->middleware(['auth', 'signed'])->name('verification.verify');



// account routes

Route::group(['prefix'=>'account'],function(){
   
    Route::group(['middleware'=>'guest'],function(){


        Route::get('/register',[AuthController::class,'register'])->name('account.register');

        Route::post('/process-register',[AuthController::class,'processRegister'])->name('account.processRegister');
        
        Route::get('/login',[AuthController::class,'login'])->name('account.login');
        
        Route::post('/authenticate',[AuthController::class,'authenticate'])->name('account.authenticate');

        Route::get('/forgot-password',[AuthController::class,'forgotPassword'])->name('account.forgotPassword');

        Route::post('/process-forgot-password',[AuthController::class,'processForgotPassword'])->name('account.processForgotPassword');

        Route::get('/reset-password/{token}',[AuthController::class,'resetPassword'])->name('account.resetPassword');

        Route::post('/process-reset-password',[AuthController::class,'processResetPassword'])->name('account.processResetPassword');

        
    });

    Route::group(['middleware'=>'auth'],function(){

        Route::get('/profile',[AuthController::class,'profile'])->name('account.profile');
        
        Route::put('/updateProfile',[AuthController::class,'updateProfile'])->name('account.updateProfile');

        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');

        Route::get('/profile/change-password',[AuthController::class,'changePassword'])->name('account.changePassword');

        Route::post('/profile/update-password',[AuthController::class,'updatePassword'])->name('account.updatePassword');

        Route::get('/my-orders',[AuthController::class,'orders'])->name('account.order');

        Route::get('/order-detail/{orderId}',[AuthController::class,'orderDetail'])->name('account.orderDetail');


    });

    Route::group(['middleware'=>['auth','verified']],function(){

        

        Route::get('/cart',[CartController::class,'cart'])->name('front.cart');

        Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('front.addToCart');

        Route::post('/update-cart',[CartController::class,'updateCart'])->name('front.updateCart');

        Route::post('/delete-item',[CartController::class,'deleteItem'])->name('front.removecart');

        Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');

        Route::post('/process-checkout',[CartController::class,'processCheckout'])->name('front.processCheckout');

        Route::get('/thanks',[CartController::class,'thanks'])->name('front.thanks');

    });
});

// admin routes


Route::group(['prefix'=>'admin'],function(){
   
    Route::group(['middleware'=>'admin.guest'],function(){
       
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
       
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
    
    });

    Route::group(['middleware'=>'admin.auth'],function(){
        
        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
       
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

        Route::get('/change-password',[HomeController::class,'changePassword'])->name('admin.changePassword');

        Route::post('/update-password',[HomeController::class,'updatePassword'])->name('admin.updatePassword');


        // Category routes


        Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');

        Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
       
        Route::get('/categories',[CategoryController::class,'index'])->name('category.index');

        Route::get('/category/{id}/edit',[CategoryController::class,'edit'])->name('category.edit');

        Route::put('/category/{id}/update',[CategoryController::class,'update'])->name('category.update');

        Route::delete('/category/{id}/delete',[CategoryController::class,'destroy'])->name('category.delete');


        // Sub_Category routes


        Route::get('/sub-category/create',[SubCategoryController::class,'create'])->name('subcategory.create');

        Route::post('/sub-category/store',[SubCategoryController::class,'store'])->name('subcategory.store');

        Route::get('/sub-categories',[SubCategoryController::class,'index'])->name('subcategory.index');

        Route::get('/sub-category/{id}/edit',[SubCategoryController::class,'edit'])->name('subcategory.edit');

        Route::put('/sub-category/{id}/update',[SubCategoryController::class,'update'])->name('subcategory.update');

        Route::delete('/sub-category/{subcategory}/delete',[SubCategoryController::class,'destroy'])->name('subcategory.delete');


        // Brand routes


        Route::get('/brand/create',[BrandController::class,'create'])->name('brand.create');
        
        Route::get('/brands',[BrandController::class,'index'])->name('brand.index');

        Route::post('/brand/store',[BrandController::class,'store'])->name('brand.store');

        Route::get('/brand/{id}/edit',[BrandController::class,'edit'])->name('brand.edit');

        Route::put('/brand/{id}/update',[BrandController::class,'update'])->name('brand.update');

        Route::delete('/brand/{id}/delete',[BrandController::class,'destroy'])->name('brand.delete');


        // Product routes


        Route::get('/product/create/{categorySlug?}',[ProductController::class,'create'])->name('product.create');

        Route::post('/product/store',[ProductController::class,'store'])->name('product.store');

        Route::get('/products',[ProductController::class,'index'])->name('product.index');

        Route::get('/product/{id}/edit',[ProductController::class,'edit'])->name('product.edit');

        Route::put('/product/{id}/update',[ProductController::class,'update'])->name('product.update');

        Route::delete('/product/{id}/delete',[ProductController::class,'destroy'])->name('product.delete');

        Route::get('/get-products',[ProductController::class,'getProducts'])->name('product.getProducts');


        // order routes


        Route::get('/orders',[OrderController::class,'index'])->name('order.index');

        Route::get('/orders/{id}',[OrderController::class,'detail'])->name('order.detail');

        Route::post('/order/updateStatus/{id}',[OrderController::class,'updateStatus'])->name('order.updateStatus');


    });

});
