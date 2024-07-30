<?php

use App\Api\V1\Http\Controllers\Auth\AuthController;
use App\Api\V1\Http\Controllers\Driver\DriverController;
use App\Api\V1\Http\Controllers\Review\ReviewController;
use App\Api\V1\Http\Controllers\Store\StoreController;
use App\Api\V1\Http\Controllers\Order\OrderController;
use App\Api\V1\Http\Controllers\User\UserController;
use App\Api\V1\Http\Controllers\Vehicle\VehicleController;
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
//***** -- discount -- ******* //
//store
Route::prefix('stores')->controller(StoreController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::post('/send-otp', 'sendOTP')->name('sendOTP');
        Route::put('/update-password', 'updatePassword')->name('updatePassword');
    });

//store
Route::prefix('vehicles')->controller(VehicleController::class)
    ->group(function () {
        Route::get('/', 'view')->name('view');
        Route::get('/show/{id}', 'show')->name('show');
    });

//auth
Route::prefix('auth')->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::put('/update-password', 'updatePassword')->name('updatePassword');
    });

//driver
Route::prefix('drivers')->controller(DriverController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/', 'update')->name('update');
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
    });

//auth
Route::prefix('auth')->controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->name('login');
    });


//order
Route::prefix('orders')->controller(OrderController::class)
    ->group(function () {
        Route::post('/book-car', 'createBookOrder')->name('createBookOrder');
        Route::post('/rent-car', 'createRentOrder')->name('createRentOrder');
        Route::delete('/{id}', 'delete')->name('delete');
    });

//... rest of your routes ...

//***** -- Category System -- ******* //
Route::controller(App\Api\V1\Http\Controllers\CategorySystem\CategorySystemController::class)
    ->prefix('/category_system')
    ->as('category_system.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
});
