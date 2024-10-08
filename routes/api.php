<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/user',[AuthController::class, 'getUser'] );
        Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::get('/countries', [CustomerController::class, 'countries']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('/orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('/orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('/orders/{order}', [OrderController::class, 'view']);
 

        Route::get('/dashboard/customers-count',[DashboardController::class, 'activeCustomers'] );
        Route::get('/dashboard/products-count',[DashboardController::class, 'activeProducts'] );
        Route::get('/dashboard/orders-count',[DashboardController::class, 'paidOrders'] );
        Route::get('/dashboard/income-amount',[DashboardController::class, 'totalIncome'] );
        Route::get('/dashboard/orders-by-country',[DashboardController::class, 'ordersByCountry'] );
        Route::get('/dashboard/latest-customers',[DashboardController::class, 'latesCustomer'] );
        Route::get('/dashboard/latest-orders',[DashboardController::class, 'latestOrder'] );
 

        
    });


Route::post('/login', [ AuthController::class, 'login'] );