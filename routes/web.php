<?php

use App\Exceptions\Handler;
use App\Http\Controllers\AdminOrderManageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HandleSearchController;
use App\Http\Controllers\HandleUserController;
use App\Http\Controllers\HandleUserOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StripePaymentController;
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
// This is the root route of the website 
Route::get('/', [ProductController::class, 'fatchProducts'])->name('home');

// These routes are related to shopping 
Route::get('shop', [ProductController::class, 'showProductsInShop'])->name('shop');
Route::post('shop/search', [HandleSearchController::class, 'searchProduct'])->name('shop.search');
Route::post('shop/search/bycategory', [HandleSearchController::class, 'searchProductByCategory'])->name('shop.search.bycategory');
Route::post('shop/add/product/tocart', [HandleUserOrderController::class, 'addToCart'])
    ->name('shop.addtocart');

// These are routes that only authicated user can excess
Route::middleware('auth')->group(function () {
    Route::get('Mycart', [HandleUserOrderController::class, 'showCartProducts'])
        ->name('mycart');
    Route::post('mycart/update/quantity', [HandleUserOrderController::class, 'updateProductQuantity'])
        ->name('update.product.quantity');
    Route::delete('delete/cart/item/{id}', [HandleUserOrderController::class, 'deleteCartItem'])
        ->name('delete.cart.item');
    Route::get('place-order', [HandleUserOrderController::class, 'viewCheckOut'])
        ->name('placeOrder');
    Route::post('place/user/order', [HandleUserOrderController::class, 'placeOrder'])
        ->name('place.order');
    Route::get('myorder', [HandleUserOrderController::class, 'myOrder'])->name('myorder');
    Route::get('order/details/{id}', [HandleUserOrderController::class, 'orderDetails'])
        ->name('order.details');
    Route::delete('order/cancel/singleitem', [HandleUserOrderController::class, 'cancelSingleOrderItem'])
        ->name('order.cancel.singleitem');
    Route::get('order/edit/{id}', [HandleUserOrderController::class, 'orderEdit'])->name('order.edit');
    Route::post('order/update/quantity', [HandleUserOrderController::class, 'updateOrderQuantity'])
        ->name('order.product.quantity');
    Route::post('order/edit/shipping/{id}', [HandleUserOrderController::class, 'updateShipping'])
        ->name('order.edit.shipping');       
    Route::delete('order/delete/{id}', [HandleUserOrderController::class, 'deleteOrder'])
        ->name('order.delete');
    Route::post('/secure/payment/{id}', [StripePaymentController::class, 'checkOut'])
        ->name('payment');
    Route::get('/secure/payment/success', [StripePaymentController::class, 'stripeCheckOutSuccess'])
    ->name('payment.success');        
});
// These are routes where authicated user can't go
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});
// This is the route where only authicated admin can have excess
Route::middleware('auth', 'admin')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])
        ->withoutMiddleware('admin')->name('logout');
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
    Route::get('/view/users', [HandleUserController::class, 'show'])->name('view.users');
    Route::get('/update/user/{id}', [HandleUserController::class, 'update'])->name('update.user');
    Route::put('/update/user/{id}', [HandleUserController::class, 'updateUser']);
    Route::get('/add/product', [ProductController::class, 'show'])->name('add.product');
    Route::post('/add/product', [ProductController::class, 'store']);
    Route::get('/view/products', [ProductController::class, 'showProducts'])->name('view.products');
    Route::get('/update/product/{id}', [ProductController::class, 'showUpdateView'])
        ->name('update.product');
    Route::put('/update/product/{id}', [ProductController::class, 'updateProduct']);
    Route::post('/add/category', [CategoryController::class, 'store'])->name('add.category');
    Route::get('/view/category', [CategoryController::class, 'showCategories'])->name('view.category');
    Route::put('/update/category/{id}/{status}', [CategoryController::class, 'updateCategory'])
        ->name('update.category');
    Route::delete('/delete/product/{id}', [ProductController::class, 'deleteProduct'])
        ->name('delete.product');
    Route::post('/dashboard/search/query', [HandleSearchController::class, 'dashboardSearchQuery'])
        ->name('dashboard.search');

    Route::get('/dashboard/order', [AdminOrderManageController::class, 'showOrders'])
        ->name('orders');    

    Route::post('/dashboard/orders/filter', [AdminOrderManageController::class, 'ordersFilter'])
        ->name('dashboard.orders.filter');     

    Route::post('dashboard/order/dispatch/{id}', [AdminOrderManageController::class, 'orderDispatch'])
        ->name('dashboard.order.dispatch');    

    Route::get('dashboard/order/details/{id}', [AdminOrderManageController::class, 'orderDetails'])
        ->name('dashboard.order.details');
    
    Route::put('dashboard/order/cancel/{id}', [AdminOrderManageController::class, 'trashOrder'])
        ->name('dashboard.order.cancel');

    Route::put('dashboard/order/restore/{id}', [AdminOrderManageController::class, 'restoreOrder'])
        ->name('dashboard.order.restore');  
        
        Route::get('/dashboard/order/trash', [AdminOrderManageController::class, 'showTrashOrders'])
        ->name('orders.trash');    
});
