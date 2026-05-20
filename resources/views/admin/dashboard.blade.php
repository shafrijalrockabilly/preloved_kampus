@extends('layouts.app')

@section('title', 'Panel Kontrol Admin | Preloved Kampus')

@section('content')
<main class="container mx-auto px-4 py-10">
    {{-- Header Dashboard --}}
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Panel Kontrol Admin</h2>
        <p class="text-gray-500 text-base mt-1">Selamat datang Moderator. Pantau dan kelola aktivitas pasar Preloved Kampus di sini.</p>
    </div>

    {{-- Grid Kartu Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <span class="text-gray-500 font-bold text-sm uppercase tracking-wider">Total Mahasiswa</span>
            <h3 class="text-4xl font-black text-gray-900 mt-4">{{ $totalUsers }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <span class="text-gray-500 font-bold text-sm uppercase tracking-wider">Total Post Barang</span>
            <h3 class="text-4xl font-black text-blue-600 mt-4">{{ $totalProducts }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <span class="text-gray-500 font-bold text-sm uppercase tracking-wider">Masih Dijual</span>
            <h3 class="text-4xl font-black text-green-600 mt-4">{{ $totalActive }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
            <span class="text-gray-500 font-bold text-sm uppercase tracking-wider">Sukses Terjual</span>
            <h3 class="text-4xl font-black text-red-600 mt-4">{{ $totalSold }}</h3>
        </div>
    </div>

    {{-- Tabel Kontrol Moderator --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Daftar Seluruh Barang Kampus</h3>
            <span class="text-xs bg-blue-50 text-blue-600 font-bold px-3 py-1 rounded-full">Mode Moderator Aktif</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs font-black uppercase tracking-wider bg-gray-50/30">
                        <th class="py-4 px-6">Barang</th>
                        <th class="py-4 px-6">Penjual</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Harga</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi Opsional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-gray-900">{{ $product->name }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $product->user->name ?? 'Mahasiswa' }}</td>
                        <td class="py-4 px-6"><span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-md">{{ $product->category }}</span></td>
                        <td class="py-4 px-6 font-semibold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            @if($product->is_sold)
                                <span class="text-red-600 bg-red-50 font-bold text-xs px-2.5 py-1 rounded-full">Sold Out</span>
                            @else
                                <span class="text-green-600 bg-green-50 font-bold text-xs px-2.5 py-1 rounded-full">Aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Hapus Langsung oleh Admin --}}
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini secara paksa sebagai Admin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Hapus Paksa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Navigasi Halaman (Pagination) --}}
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/20">
            {{ $products->links() }}
        </div>
    </div>
</main>
@endsection