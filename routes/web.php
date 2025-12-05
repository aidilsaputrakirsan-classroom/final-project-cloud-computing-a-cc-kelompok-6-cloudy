<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\UserCatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // if (auth()->check()) {
    //     if (auth()->user()->role === 'admin') {
    //         return redirect()->route('dashboard');
    //     } else {
    //         return redirect()->route('user.catalog');
    //     }
    // }
    return redirect()->route('user.catalog');
});

// User Catalog routes
Route::get('/user/catalog', [UserCatalogController::class, 'index'])->name('user.catalog');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/activity-log', function () {
    $logs = \DB::table('activity_logs')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('admin.activity-log', compact('logs'));
    })->name('admin.activity-log');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tambahan Baru: User Product Detail
    Route::get('/user/product/{id}', [UserProductController::class, 'detail'])
        ->name('user.product.detail');

     // Halaman form pesanan
    Route::get('/order/{id}', [OrderController::class, 'create'])->name('order.create');

    // Simpan pesanan
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin', fn () => redirect('/admin/products'))->name('admin.index');
    
    // Categories routes
    Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Products routes
    Route::prefix('admin/products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    //Pemesanan routes
    Route::prefix('admin/pemesanan')->name('admin.pemesanan.')->group(function () {
        Route::get('/', [PemesananController::class, 'index'])->name('index');
        Route::post('/', [PemesananController::class, 'store'])->name('store');
        Route::put('/{id}', [PemesananController::class, 'update'])->name('update');
        Route::delete('/{id}', [PemesananController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';