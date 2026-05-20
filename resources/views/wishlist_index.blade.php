@extends('layouts.app')

@section('title', 'Wishlist Saya | Preloved Kampus')

@section('content')
    <main class="container mx-auto px-4 py-6 md:py-10">
        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 md:mb-10 gap-4">
            <div>
                <h2 class="text-xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Wishlist Saya
                </h2>
                <p class="text-xs md:text-base text-gray-500 mt-0.5">Barang-barang favorit yang kamu incar.</p>
            </div>
        </div>

        {{-- Grid Produk Wishlist (Responsif 2 Kolom di HP) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-8">
            @forelse($products as $item)
                @php
                    // Menyusun data item agar sesuai dengan parameter fungsi showDetail() di app.blade.php
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
                        'is_liked' => true // Karena ada di halaman wishlist, otomatis statusnya true
                    ];
                @endphp

                <div class="group bg-white rounded-2xl md:rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 cursor-pointer relative"
                    onclick="showDetail({{ json_encode($itemData) }})">

                    {{-- FIX: IMAGE SECTION SEKARANG PERSEGI SEMPURNA (aspect-square) --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $item->image) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $item->is_sold ? 'grayscale brightness-50' : '' }}">

                        @if ($item->is_sold)
                            <div class="absolute inset-0 flex items-center justify-center z-20">
                                <span class="bg-red-600 text-white text-[9px] md:text-xs font-black px-3 py-1.5 md:px-4 md:py-2 rounded-lg shadow-2xl uppercase rotate-[-10deg] ring-1 md:ring-2 ring-white">
                                    Sold Out
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- DETAIL INFO SECTION --}}
                    <div class="p-3 md:p-5">
                        <h3 class="font-bold text-gray-800 text-xs md:text-base leading-snug line-clamp-2 h-8 md:h-12 {{ $item->is_sold ? 'text-gray-400' : '' }}">
                            {{ $item->name }}
                        </h3>
                        <div class="mt-1 md:mt-3 flex flex-col gap-1">
                            <span class="{{ $item->is_sold ? 'text-gray-400 line-through text-xs md:text-sm' : 'text-blue-600 font-black text-sm md:text-xl' }}">
                                {{ $itemData['price'] }}
                            </span>
                        </div>

                        <div class="mt-3 md:mt-5 pt-3 md:pt-4 border-t border-gray-50 flex items-center justify-between gap-1">
                            <div class="flex items-center gap-0.5 truncate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-[9px] md:text-[10px] text-gray-500 font-medium truncate max-w-[65px] md:max-w-[80px] capitalize">
                                    {{ $item->location ?? 'Sekitar Kampus' }}
                                </span>
                            </div>
                            <span class="text-blue-600 font-bold text-[9px] md:text-[11px] whitespace-nowrap">Detail →</span>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika data wishlist kosong --}}
                <div class="col-span-full py-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 italic text-sm md:text-lg">Belum ada barang di wishlist kamu.</p>
                    <a href="/" class="mt-4 inline-block bg-blue-600 text-white px-5 py-2 rounded-xl text-xs md:text-sm font-bold shadow-md hover:bg-blue-700 transition-all">
                        Cari Barang Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </main>
@endsection