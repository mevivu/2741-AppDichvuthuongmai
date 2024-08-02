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
Route::controller(App\Api\V1\Http\Controllers\Discount\DiscountController::class)->prefix('/discounts')
    ->as('discount.')
    ->group(function () {
        Route::get('/', 'index')->name('index'); // Route xuất ra danh sách các discount
        Route::get('/show/{id}', 'show')->name('show'); // Route xem chi tiết 1 discount, tham số là {id} là discountid
        Route::get('/store/{storeId}', 'getByStore')->name('getByStore'); // Route lấy danh sách discount theo store_id
        Route::get('/user/{userId}', 'getByUser')->name('getByUser');
        Route::get('/driver/{driverId}', 'getByDriver')->name('getByDriver');
        // Route::get('/product/{productId}', 'getByProduct')->name('getByProduct');
        Route::get('/store/{storeId}/discount/{discountId}', 'getDiscountByStoreAndId')->name('getDiscountByStoreAndId');
        Route::get('/product/{productId}', 'getByProduct')->name('getByProduct');

    });
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

//notification
Route::controller(App\Api\V1\Http\Controllers\Notification\UserNotificationController::class)
    ->prefix('/notifications')
    ->as('note.')
    ->group(function () {
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/user', 'getUserNotifications')->name('getNotiUser');
        Route::get('/driver', 'getDriverNotifications')->name('getNotiDriver');

});

//notification
Route::controller(App\Api\V1\Http\Controllers\Notification\StoreNotificationController::class)
    ->prefix('/notifications')
    ->as('note.')
    ->group(function () {
        Route::get('/store', 'getStoreNotifications')->name('getNotiStore');

});

//products
Route::controller(App\Api\V1\Http\Controllers\Product\ProductController::class)
    ->prefix('/products')
    ->as('product.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::delete('/{id}', 'delete')->name('delete');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
    });

//vehicles
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


//post category
Route::controller(App\Api\V1\Http\Controllers\PostCategory\PostCategoryController::class)
    ->prefix('/posts-categories')
    ->as('post_catogery.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });

//posts
Route::controller(App\Api\V1\Http\Controllers\Post\PostController::class)
    ->prefix('/posts')
    ->as('post.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/featured', 'featured')->name('featured');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/related/{id}', 'related')->name('related');
    });
//Toppings
Route::controller(App\Api\V1\Http\Controllers\Topping\ToppingController::class)
    ->prefix('/toppings')
    ->as('topping.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/delete', 'delete')->name('delete');
        Route::post('/add', 'add')->name('add');
        Route::put('/edit', 'edit')->name('edit');
    });
//review product
Route::controller(App\Api\V1\Http\Controllers\Review\ReviewController::class)
    ->prefix('/reviews')
    ->as('review.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store')->middleware('auth:sanctum');
        Route::get('/filter', 'filter')->name('filter');

    });


Route::middleware('auth:sanctum')->group(function () {


    //shopping cart
    Route::controller(App\Api\V1\Http\Controllers\ShoppingCart\ShoppingCartController::class)
        ->prefix('/shopping-cart')
        ->as('shopping_cart.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });
});
//cart
Route::controller(App\Api\V1\Http\Controllers\Cart\CartController::class)
    ->group(function () {
        Route::middleware('auth:sanctum')->prefix('/carts')->as('cart.')->group(function () {
            Route::get('/', 'show')->name('show');
            Route::post('/calculate', 'calculateTotal')->name('calculate');
            Route::post('/', 'store')->name('store');
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'delete')->name('delete');
        });
    });

Route::prefix('/category')
    ->as('category.')
    ->group(function () {
        Route::controller(App\Api\V1\Http\Controllers\Category\CategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/product', 'product')->name('product');
                Route::get('/show/{id}', 'show')->name('show');
            });
        Route::middleware('auth:sanctum')
            ->controller(App\Api\V1\Http\Controllers\Category\CategoryAuthController::class)
            ->prefix('/auth')
            ->as('auth.')
            ->group(function () {
                Route::get('/product', 'product')->name('product');
                Route::get('/show/{id}', 'show')->name('show');
            });
    });


Route::prefix('/product')
    ->as('product.')
    ->group(function () {
        Route::controller(App\Api\V1\Http\Controllers\Product\ProductController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');
            });
        Route::controller(App\Api\V1\Http\Controllers\Product\ProductVariationController::class)
            ->prefix('/variation')
            ->as('variation.')
            ->group(function () {
                Route::get('/show', 'show')->name('show');
            });

        Route::middleware('auth:sanctum')
            ->prefix('/auth')
            ->as('auth.')
            ->group(function () {
                Route::controller(App\Api\V1\Http\Controllers\Product\ProductAuthController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/show/{id}', 'show')->name('show');
                });
                Route::controller(App\Api\V1\Http\Controllers\Product\ProductAuthVariationController::class)
                    ->prefix('/variation')
                    ->as('variation.')
                    ->group(function () {
                        Route::get('/show', 'show')->name('show');
                    });
            });

    });

//slider
Route::controller(App\Api\V1\Http\Controllers\Slider\SliderController::class)
    ->prefix('/slider')
    ->as('slider.')
    ->group(function () {
        Route::get('/show/{key}', 'show')->name('show');
    });


Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => __('Không tìm thấy đường dẫn.')
    ], 404);
});

//Topping
Route::controller(App\Api\V1\Http\Controllers\Topping\ToppingController::class)
    ->prefix('/toppings')
    ->as('topping.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::delete('/delete', 'delete')->name('delete');
        Route::post('/add', 'add')->name('add');
        Route::put('/edit', 'edit')->name('edit');
    });
//***** -- Category System -- ******* //
Route::controller(App\Api\V1\Http\Controllers\CategorySystem\CategorySystemController::class)
    ->prefix('/category_system')
    ->as('category_system.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });
