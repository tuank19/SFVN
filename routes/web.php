<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('Admin');

Route::get('login', [UserController::class, 'login'])->name('login')->middleware('auth.check');
Route::post('login', [UserController::class, 'loginSubmit'])->name('login.submit')->middleware('auth.check');
Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'category','middleware' => ['Admin']], function(){
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store'])->name('submit.create-category');
    Route::post('/edit-{catUUID}', [CategoryController::class, 'edit'])->name('submit.edit-category');
    Route::delete('/delete-{catUUID}', [CategoryController::class, 'softDelete'])->name('submit.delete-category');

});

Route::group(['prefix' => 'product','middleware' => ['Admin']], function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/create', [ProductController::class, 'create'])->name('create-product');
    Route::post('/create', [ProductController::class, 'submitCreate'])->name('submit.create-product');
    Route::get('/edit-{uuid}', [ProductController::class, 'edit'])->name('edit-product');
    Route::post('/edit-{uuid}', [ProductController::class, 'submitEdit'])->name('submit.edit-product');
    Route::delete('/delete-{uuid}', [ProductController::class, 'softDelete'])->name('submit.delete-product');
    Route::get('/get-product-{catUUID}', [ProductController::class, 'getProduct'])->name('get.product');
});

Route::group(['prefix' => 'attrs','middleware' => ['Admin']], function(){
    Route::get('/', [AttributeController::class, 'index']);
    Route::post('/add-new', [AttributeController::class, 'create'])->name('submit.new-attribute');
    Route::post('/edit-{uuid}', [AttributeController::class, 'edit'])->name('submit.edit-attribute');
});

Route::group(['prefix' => 'order','middleware' => ['Admin']], function(){
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/create', [OrderController::class, 'create'])->name('crate.order');
    Route::post('/create', [OrderController::class, 'submitCreateOrder'])->name('submit.create-order');
    Route::get('/edit-{orderNumber}', [OrderController::class, 'edit'])->name('edit.order');
    Route::post('/edit-{orderNumber}', [OrderController::class, 'submitEdit'])->name('submit.edit-order');

});

Route::group(['prefix' => 'customer','middleware' => ['Admin']], function(){
    Route::get('/', [CustomerController::class, 'index']);
    Route::post('/create', [CustomerController::class, 'create'])->name('submit.create-customer');
    Route::get('/get-customer-{uuid}', [CustomerController::class, 'getCustomer'])->name('get.customer');
    Route::get('/edit-{uuid}', [CustomerController::class, 'editCustomer'])->name('edit.customer');
    Route::post('/edit-{uuid}', [CustomerController::class, 'submitEditCustomer'])->name('submit.edit-customer');
});

Route::group(['prefix' => 'invoice','middleware' => ['Admin']], function(){
    Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/{id}', [InvoiceController::class, 'view'])->name('view-invoice');

});

Route::group(['prefix' => 'utils'], function(){
    Route::get('/city', [ToolController::class, 'cityList'])->name('get_city_list');
    Route::get('/get-district/{cityID}', [ToolController::class, 'districtList'])->name('get_district_list');
    Route::get('/get-ward/{districtID}', [ToolController::class, 'wardList'])->name('get_ward_list');
});


