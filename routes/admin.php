<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Admin\Http\Controllers\Home\HomeController::class, 'index']);

// login
Route::controller(App\Admin\Http\Controllers\Auth\LoginController::class)
->middleware('guest:admin')
->prefix('/login')
->as('login.')
->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/', 'login')->name('post');
});

Route::group(['middleware' => 'admin.auth.admin:admin'], function(){


	//***** -- Module -- ******* //
    Route::prefix('/module')->as('module.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Module\ModuleController::class)->group(function(){
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/summary', 'summary')->name('summary');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });
	//***** -- Module -- ******* //

	//***** -- Permission -- ******* //
    Route::prefix('/permission')->as('permission.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Permission\PermissionController::class)->group(function(){
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });
	//***** -- Permission -- ******* //

	//***** -- Role -- ******* //
    Route::prefix('/role')->as('role.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Role\RoleController::class)->group(function(){
			
            Route::group(['middleware' => ['permission:createRole', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewRole', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateRole', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteRole', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
    });
	//***** -- Role -- ******* //



    //Post
    Route::prefix('/posts')->as('post.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Post\PostController::class)->group(function(){
            
			Route::group(['middleware' => ['permission:createPost', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewPost', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updatePost', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deletePost', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
    });

	


    //Post category
    Route::prefix('/posts-categories')->as('post_category.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\PostCategory\PostCategoryController::class)->group(function(){
            Route::group(['middleware' => ['permission:createPostCategory', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewPostCategory', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updatePostCategory', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deletePostCategory', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
    });

    //Settings
    Route::controller(App\Admin\Http\Controllers\Setting\SettingController::class)
    ->prefix('/settings')
    ->as('setting.')
    ->group(function(){
		Route::group(['middleware' => ['permission:settingGeneral', 'auth:admin']], function () {
			Route::get('/general', 'general')->name('general');
		});
        
        Route::get('/user-shopping', 'userShopping')->name('user_shopping');
        Route::put('/update', 'update')->name('update');
    });

    //sliders
    Route::prefix('/sliders')->as('slider.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Slider\SliderItemController::class)
        ->as('item.')
        ->group(function(){
            Route::get('/{slider_id}/item/them', 'create')->name('create');
            Route::get('/{slider_id}/item', 'index')->name('index');
            Route::get('/item/sua/{id}', 'edit')->name('edit');
            Route::put('/item/sua', 'update')->name('update');
            Route::post('/item/them', 'store')->name('store');
            Route::delete('/{slider_id}/item/xoa/{id}', 'delete')->name('delete');
        });
        Route::controller(App\Admin\Http\Controllers\Slider\SliderController::class)->group(function(){
            Route::group(['middleware' => ['permission:createSlider', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewSlider', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateSlider', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteSlider', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
    });

    //Order detail
    Route::controller(App\Admin\Http\Controllers\Order\OrderDetailController::class)
    ->prefix('order-detail')
    ->as('order_detail.')
    ->group(function(){
        Route::delete('/delete/{id?}', 'delete')->name('delete');
    });
    
    //Order
    Route::prefix('/orders')->as('order.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Order\OrderController::class)->group(function(){
			Route::group(['middleware' => ['permission:createOrder', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
            
			Route::group(['middleware' => ['permission:viewOrder', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
			
			
            Route::group(['middleware' => ['permission:updateOrder', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
            Route::group(['middleware' => ['permission:deleteOrder', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			});
              
            Route::get('/render-info-shipping', 'renderInfoShipping')->name('render_info_shipping');
            Route::get('/add-product', 'addProduct')->name('add_product');
            Route::get('/calculate-total-before-save-order', 'calculateTotalBeforeSaveOrder')->name('calculate_total_before_save_order');
        });
    });
    //attributes
    Route::prefix('/attributes')->as('attribute.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\AttributeVariation\AttributeVariationController::class)
        ->as('variation.')
        ->group(function(){
            Route::get('/{attribute_id}/variations/them', 'create')->name('create');
            Route::get('/{attribute_id}/variations', 'index')->name('index');
            Route::get('/variations/sua/{id}', 'edit')->name('edit');
            Route::put('/variations/sua', 'update')->name('update');
            Route::post('/variations/them', 'store')->name('store');
            Route::delete('/{attribute_id}/variations/xoa/{id}', 'delete')->name('delete');
        });
        Route::controller(App\Admin\Http\Controllers\Attribute\AttributeController::class)->group(function(){
            Route::group(['middleware' => ['permission:createProductAttribute', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewProductAttribute', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateProductAttribute', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteProductAttribute', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
    });

    //Product
    Route::prefix('/products')->as('product.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Product\ProductController::class)->group(function(){
            Route::group(['middleware' => ['permission:createProduct', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewProduct', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateProduct', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteProduct', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
        Route::controller(App\Admin\Http\Controllers\Product\ProductAttributeController::class)
        ->prefix('/attributes')
        ->as('attribute.')
        ->group(function(){
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
        Route::controller(App\Admin\Http\Controllers\Product\ProductVariationController::class)
        ->prefix('/variations')
        ->as('variation.')
        ->group(function(){
            Route::get('/check', 'check')->name('check');
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });

    //Category
    Route::prefix('/categories')->as('category.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Category\CategoryController::class)->group(function(){
            Route::group(['middleware' => ['permission:createProductCategory', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewProductCategory', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateProductCategory', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteProductCategory', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			});
        });
    });

    //user
    Route::prefix('/users')->as('user.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\User\UserController::class)->group(function(){
            Route::group(['middleware' => ['permission:createUser', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewUser', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateUser', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteUser', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			});
        });
        // Route::get('/select-search', [AdminSearchController::class, 'selectSearch'])->name('selectsearch');
    });
    //admin
    Route::prefix('/admins')->as('admin.')->group(function(){
        Route::controller(App\Admin\Http\Controllers\Admin\AdminController::class)->group(function(){
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
				 Route::get('/them', 'create')->name('create');
				 Route::post('/them', 'store')->name('store');
			});
			Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
				 Route::get('/', 'index')->name('index');
				 Route::get('/sua/{id}', 'edit')->name('edit');
			});
            
			Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
				Route::put('/sua', 'update')->name('update');
			});
            
			Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
				Route::delete('/xoa/{id}', 'delete')->name('delete');
			}); 
        });
        // Route::get('/select-search', [AdminSearchController::class, 'selectSearch'])->name('selectsearch');
    });

    //ckfinder
    Route::prefix('/quan-ly-file')->as('ckfinder.')->group(function(){
        Route::any('/ket-noi', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('connector');
        Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('browser');
    });
    Route::get('/dashboard', [App\Admin\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //auth
    Route::controller(App\Admin\Http\Controllers\Auth\ProfileController::class)
    ->prefix('/profile')
    ->as('profile.')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });

    Route::controller(App\Admin\Http\Controllers\Auth\ChangePasswordController::class)
    ->prefix('/password')
    ->as('password.')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });
    Route::prefix('/search')->as('search.')->group(function(){
        Route::prefix('/select')->as('select.')->group(function(){
            Route::get('/user', [App\Admin\Http\Controllers\User\UserSearchSelectController::class, 'selectSearch'])->name('user');
        });
        Route::get('/render-product-and-variation', [App\Admin\Http\Controllers\Product\ProductController::class, 'searchRenderProductAndVariation'])->name('render_product_and_variation');
    });
    Route::post('/logout', [App\Admin\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});