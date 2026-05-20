<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Toggle status di database
        $user->wishlist()->toggle($product->id);
        
        // Pastikan nama session ini adalah 'openModalId'
        return back()->with('openModalId', $product->id);
    }

    public function index()
{
    // Mengambil produk yang di-wishlist oleh user login
    $products = auth()->user()->wishlist()
                ->with(['user', 'favoritedBy']) // Eager Loading sangat penting!
                ->latest()
                ->get();

    return view('wishlist_index', compact('products'));
}
}