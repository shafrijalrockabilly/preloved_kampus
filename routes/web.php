<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController; // Import ini sangat penting
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rute Publik (Tanpa Login) ---
Route::get('/', function (Request $request) {
    // Eager Loading 'user' dan 'favoritedBy' agar fitur wishlist di modal lancar
    $query = Product::with(['user', 'favoritedBy'])->latest();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    $products = $query->get();

    return view('welcome', compact('products'));
})->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


// --- Grup Rute Auth (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // --- Profil User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Manajemen Produk ---
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/product/{id}/toggle-sold', [ProductController::class, 'toggleSold'])->name('product.toggleSold');
    
    // Pastikan baris ini ada di dalam Route::middleware('auth')->group(function () { ...

    // Pastikan baris ini ada di dalam Route::middleware('auth')->group(function () { ...

    // 1. Halaman Kelola Barang Milik Sendiri
    Route::get('/my-products', [ProductController::class, 'myProducts'])->name('product.my');

    // 2. Logika Simpan/Hapus Wishlist (Harus POST)
    // Gunakan {product} untuk binding otomatis ke Model Product
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    // 3. Halaman Daftar Wishlist Saya
    Route::get('/my-wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// });
});

require __DIR__.'/auth.php';