<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\BmiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;




Route::get('/search', [ProductController::class, 'search'])->name('product.search');

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });

        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [AdminProductController::class, 'create']);
            Route::post('add', [AdminProductController::class, 'store']);
            Route::get('list', [AdminProductController::class, 'index']);
            Route::get('edit/{product}', [AdminProductController::class, 'show']);
            Route::post('edit/{product}', [AdminProductController::class, 'update']);
            Route::DELETE('destroy', [AdminProductController::class, 'destroy']);
        });

        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });

        #Posts
        Route::prefix('posts')->group(function () {
            Route::get('add', [AdminPostController::class, 'create']);
            Route::post('add', [AdminPostController::class, 'store'])->name('posts.add');
            Route::get('list', [AdminPostController::class, 'index']);
            Route::get('edit/{post}', [AdminPostController::class, 'show']);
            Route::post('edit/{post}', [AdminPostController::class, 'update']);
            Route::DELETE('destroy', [AdminPostController::class, 'destroy']);
        });

        #Upload
        Route::post('upload/services', [\App\Http\Controllers\Admin\UploadController::class, 'store']);

        #Cart
        Route::get('customers', [\App\Http\Controllers\Admin\CartController::class, 'index']);
        Route::get('customers/view/{customer}', [\App\Http\Controllers\Admin\CartController::class, 'show']);
    });
});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);

Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'index']);

Route::get('bmi-caculator', [App\Http\Controllers\BmiController::class, 'index'])->name('bmi-caculator');
Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'remove']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);



Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// Route cho danh sách sản phẩm và tìm kiếm
// Route::get('/products', [ProductController::class, 'list'])->name('products.index');
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
// Route::get('/san-pham/{id}-{slug}.html', [ProductController::class, 'show'])->name('product.show');
Route::get('post', [PostController::class, 'index'])->name('post');
Route::get('bai-viet/{id}-{slug}.html', [App\Http\Controllers\PostController::class, 'index']);
Route::get('/bai-viet/{id}-{slug}.html', [PostController::class, 'show'])->name('post.show');
// Route::post('/admin/invoices/status/{id}', [InvoiceController::class, 'updateStatus']);
Route::post('/admin/customers/update-status/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'updateStatus'])->name('customers.update-status');
// Route::put('/admin/customers/update-status/{customer}', 'CustomerController@updateStatus')->name('customers.update-status');
// Route::post('/admin/customers/update-status/{customer}', 'CustomerController@updateStatus')->name('customers.update-status');
