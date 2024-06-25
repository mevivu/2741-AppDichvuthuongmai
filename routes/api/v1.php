<?php

use App\Api\V1\Http\Controllers\Store\StoreController;
use App\Api\V1\Http\Controllers\Order\OrderController;
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

//auth
Route::prefix('store')->controller(StoreController::class)
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::post('/send-otp', 'sendOTP')->name('sendOTP');

    });


//order
Route::prefix('orders')->controller(OrderController::class)
    ->group(function () {
        Route::post('/book-car', 'createBookOrder')->name('createBookOrder');
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
//review product
Route::controller(App\Api\V1\Http\Controllers\Review\ReviewController::class)
    ->prefix('/reviews')
    ->as('review.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store')->middleware('auth:sanctum');
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



Route::controller(App\Api\V1\Http\Controllers\Store\ResetPasswordController::class)
    ->prefix('/reset-password')
    ->as('reset_password.')
    ->group(function () {
        Route::post('/', 'checkAndSendMail')->name('check_and_send_mail');
    });

Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => __('Không tìm thấy đường dẫn.')
    ], 404);
});
