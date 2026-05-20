@extends('layouts.app')

@section('title', 'Barang Saya | Preloved Kampus')

@section('content')
<main class="container mx-auto px-4 py-6 md:py-10">
    {{-- Header Judul Halaman --}}
    <div class="mb-6 md:mb-10">
        <h2 class="text-xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Barang Saya</h2>
        <p class="text-xs md:text-base text-gray-500 mt-0.5">Kelola barang yang Anda jual di sini.</p>
    </div>

    {{-- Grid Card Produk Responsif --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-8">
        @forelse($products as $item)
            @php
                $itemData = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category' => $item->category,
                    'price' => 'Rp ' . number_format($item->price, 0, ',', '.'),
                    'location' => $item->location ?? 'Sekitar Kampus',
                    'description' => $item->description,
                    'image' => asset('storage/' . $item->image),
                    'whatsapp_number' => $item->whatsapp_number,
                    'user_name' => $item->user->name ?? 'Mahasiswa',
                    'is_sold' => (bool) $item->is_sold,
                ];
            @endphp

            <div class="group bg-white rounded-2xl md:rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 cursor-pointer relative"
                onclick="showDetail({{ json_encode($itemData) }})">
                
                {{-- FIX POSITIONING: Pembungkus Gambar diatur relative agar overlay terkunci di dalam sini saja --}}
                <div class="relative aspect-square overflow-hidden bg-gray-100">
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $item->is_sold ? 'grayscale brightness-50' : '' }}">
                    
                    {{-- Overlay Sold Out dipindahkan ke dalam container gambar agar tidak menutupi tombol --}}
                    @if ($item->is_sold)
                        <div class="absolute inset-0 bg-black/30 z-10 flex items-center justify-center">
                            <span class="bg-red-600 text-white text-[9px] md:text-xs font-black px-3 py-1.5 rounded-lg shadow-2xl uppercase rotate-[-10deg] ring-1 ring-white tracking-wider">
                                Terjual
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Rincian Deskripsi & Kelompok Tombol Aksi --}}
                <div class="p-3 md:p-5">
                    <h3 class="font-bold text-gray-800 text-xs md:text-base leading-snug line-clamp-1 {{ $item->is_sold ? 'text-gray-400' : '' }}">
                        {{ $item->name }}
                    </h3>
                    <p class="text-blue-600 font-black text-sm md:text-xl mt-1">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </p>
                    
                    {{-- Area Tombol Manajemen --}}
                    <div class="mt-4 grid grid-cols-2 gap-2" onclick="event.stopPropagation()">
                        {{-- Tombol Edit --}}
                        <button onclick="editProduct({{ json_encode($item) }})" 
                                class="flex items-center justify-center gap-1 bg-amber-50 text-amber-600 py-2 rounded-xl text-[11px] md:text-xs font-bold hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                            Edit
                        </button>
                        
                        {{-- Tombol Hapus (Sekarang dijamin selalu aktif & bisa diklik) --}}
                        <form action="{{ route('product.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')" class="w-full">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-1 bg-red-50 text-red-600 py-2 rounded-xl text-[11px] md:text-xs font-bold hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/xl" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <p class="text-gray-400 italic text-base md:text-lg">Anda belum memposting barang apa pun.</p>
                <button onclick="openAddModal()" class="mt-4 bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 transition-all">
                    Mulai Jual Barang
                </button>
            </div>
        @endforelse
    </div>
</main>
@endsection