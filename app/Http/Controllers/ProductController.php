<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Penting untuk menghilangkan error merah

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'whatsapp_number' => 'required',
            'description' => 'nullable',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Menggunakan Auth::id() agar VS Code tidak merah
        $data['user_id'] = Auth::id();

        Product::create($data);

        return redirect('/')->with('success', 'Barang berhasil diposting!');
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    
    // Proteksi kepemilikan
    if (Auth::id() !== $product->user_id && Auth::user()->role !== 'admin') {
        return back()->with('error', 'Anda tidak berhak mengedit barang ini!');
    }

    $data = $request->validate([
        'name' => 'required',
        'category' => 'required',
        'price' => 'required|numeric',
        'location' => 'required',
        'whatsapp_number' => 'required',
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
    ]);

    // LOGIKA BARU: Update status is_sold
    // Jika checkbox dicentang nilainya 1, jika tidak nilainya 0
    $data['is_sold'] = $request->has('is_sold') ? 1 : 0;

    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($data);

    return back()->with('success', 'Barang diperbarui!');
}

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Proteksi kepemilikan
        if (Auth::id() !== $product->user_id && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak berhak menghapus barang ini!');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Barang berhasil dihapus!');
    }
    public function toggleSold($id)
{
    $product = Product::findOrFail($id);
    
    // Perbaikan proteksi: Pemilik barang ATAU Admin boleh akses
    if (auth()->id() !== $product->user_id && auth()->user()->role !== 'admin') {
        return back()->with('error', 'Akses ditolak');
    }

    // Toggle status
    $product->is_sold = $product->is_sold ? 0 : 1;
    $product->save();

    return back()->with('success', 'Status berhasil diperbarui');
}
public function myProducts()
{
    // Mengambil data produk milik user login
    $products = Product::where('user_id', auth()->id())->latest()->get();
    return view('my_products', compact('products'));
}
}