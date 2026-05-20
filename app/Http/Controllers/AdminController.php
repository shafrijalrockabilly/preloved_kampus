<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil data ringkasan untuk statistik dashboard
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalSold = Product::where('is_sold', true)->count();
        $totalActive = Product::where('is_sold', false)->count();

        // Mengambil seluruh data produk untuk tabel kontrol moderator
        $products = Product::with('user')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalProducts', 
            'totalSold', 
            'totalActive', 
            'products'
        ));
    }
}