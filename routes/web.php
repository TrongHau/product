
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\SupplierManagementController;
use App\Http\Controllers\WarehouseManagementController;
use App\Http\Controllers\EnterWarehouseManagementController;
use App\Http\Controllers\Auth\CallBackController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// Homepage Route
Route::get('callback', [CustomAuthController::class, 'callBack'])->name('callback');



Route::get('login', [CustomAuthController::class, 'index'])->name('login');

Route::post('login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::post('reset-password', [CustomAuthController::class, 'resetPassword'])->name('login.reset_password');

Route::get('logout', [CustomAuthController::class, 'signOut'])->name('signout');

//Route::put('reset-password/{token}', 'ResetPasswordController@reset');
Route::get('/supplier', [SupplierManagementController::class, 'index'])->name('supplier.index');


Route::group(
    ['middleware' => ['auth', 'web']],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/product', [ProductManagementController::class, 'index'])->name('product.index');
        Route::get('/create-product', [ProductManagementController::class, 'create'])->name('product.create');
        Route::post('/create-product', [ProductManagementController::class, 'store'])->name('product.store');
        Route::post('/product-delete', [ProductManagementController::class, 'delete'])->name('product.delete');
        Route::get('/edit-product/{id}', [ProductManagementController::class, 'edit'])->name('product.edit');
        Route::get('/detail-product/{id}', [ProductManagementController::class, 'detail'])->name('product.detail');
        Route::post('/edit-product/{id}', [ProductManagementController::class, 'update'])->name('product.update');


//        Route::get('/supplier', [SupplierManagementController::class, 'index'])->name('supplier.index');
        Route::post('/create-supplier', [SupplierManagementController::class, 'store'])->name('supplier.store');
        Route::post('/supplier-delete', [SupplierManagementController::class, 'delete'])->name('supplier.delete');
        Route::get('/edit-supplier/{id}', [SupplierManagementController::class, 'edit'])->name('supplier.edit');


        Route::get('/warehouse', [WarehouseManagementController::class, 'index'])->name('warehouse.index');
        Route::post('/create-warehouse', [WarehouseManagementController::class, 'store'])->name('warehouse.store');
        Route::post('/warehouse-delete', [WarehouseManagementController::class, 'delete'])->name('warehouse.delete');
        Route::get('/edit-warehouse/{id}', [WarehouseManagementController::class, 'edit'])->name('warehouse.edit');

        Route::get('/enter_warehouse', [EnterWarehouseManagementController::class, 'index'])->name('enter_warehouse.index');
        Route::get('/enter_warehouse/create', [EnterWarehouseManagementController::class, 'create'])->name('enter_warehouse.create');
        Route::post('/create-enter_warehouse', [EnterWarehouseManagementController::class, 'store'])->name('enter_warehouse.store');
        Route::post('/search-product', [ProductManagementController::class, 'search'])->name('product.search');
        Route::post('/product-detail-search', [ProductManagementController::class, 'detail_search'])->name('product.detail_search');
        Route::get('/edit-enter_warehouse/{id}', [EnterWarehouseManagementController::class, 'edit'])->name('enter_warehouse.edit');
        Route::post('/edit-enter_warehouse/{id}', [EnterWarehouseManagementController::class, 'update'])->name('enter_warehouse.edit');
        Route::get('/detail-enter_warehouse/{id}', [EnterWarehouseManagementController::class, 'detail'])->name('enter_warehouse.detail');

    }
);
