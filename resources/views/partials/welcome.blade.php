@extends('layouts.app')

@section('title', 'Beranda | Preloved Kampus')

@section('content')
    {{-- Bagian Kategori yang Sticky & Swipeable di HP --}}
    <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 py-3 sticky top-[108px] md:top-[65px] z-30 transition-all duration-300">
        <div class="container mx-auto px-4 flex gap-2 overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            <a href="/"
                class="{{ !request('category') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} px-5 py-1.5 rounded-full text-xs md:text-sm font-bold whitespace-nowrap transition-all">
                Semua
            </a>
            @php $categories = ['Buku Kuliah', 'Elektronik', 'Perkakas Kos', 'Fashion', 'Lainnya']; @endphp
            @foreach ($categories as $cat)
                <a href="/?category={{ $cat }}"
                    class="{{ request('category') == $cat ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} px-5 py-1.5 rounded-full text-xs md:text-sm font-medium whitespace-nowrap transition-all">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 md:py-10">
        {{-- Judul Rekomendasi --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 md:mb-10 gap-1">
            <div>
                <h2 class="text-xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
                    {{ request('search') ? 'Hasil Pencarian: "' . request('search') . '"' : (request('category') ? 'Kategori: ' . request('category') : 'Rekomendasi Hari Ini') }}
                </h2>
                <p class="text-xs md:text-base text-gray-500 mt-0.5">Barang bekas berkualitas dari sesama mahasiswa.</p>
            </div>
        </div>

        {{-- Grid Produk Responsif (2 Kolom di HP, Naik Bertahap di Layar Besar) --}}
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
                        'is_liked' => auth()->check() ? ($item->favoritedBy ? $item->favoritedBy->contains(auth()->id()) : false) : false,
                    ];
                @endphp

                <div class="group bg-white rounded-2xl md:rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 cursor-pointer relative"
                    onclick="showDetail({{ json_encode($itemData) }})">

                    {{-- TOMBOL MANAGEMENT (OVERLAY DI ATAS GAMBAR) --}}
                    @auth
                        @if (auth()->user()->role == 'admin' || auth()->id() == $item->user_id)
                            <div class="absolute top-2.5 right-2.5 z-30 flex flex-col gap-1.5" onclick="event.stopPropagation()">
                                {{-- Tombol Toggle Sold --}}
                                <form action="{{ route('product.toggleSold', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-xl shadow-md transition-all {{ $item->is_sold ? 'bg-green-600 text-white' : 'bg-white/90 backdrop-blur-md text-gray-400 hover:text-green-600' }}"
                                        title="{{ $item->is_sold ? 'Tandai Tersedia' : 'Tandai Terjual' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Tombol Edit --}}
                                <button type="button" onclick="editProduct({{ json_encode($item) }})"
                                    class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center bg-white/90 backdrop-blur-md text-amber-600 rounded-xl shadow-md hover:bg-amber-500 hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('product.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center bg-white/90 backdrop-blur-md text-red-600 rounded-xl shadow-md hover:bg-red-500 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-4 md:w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    {{-- IMAGE SECTION --}}
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100">
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

                    {{-- TEXT INFO SECTION --}}
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
                            <div class="flex items-center gap-0.5 md:gap-1 truncate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 md:h-3 md:w-3 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-[9px] md:text-[10px] text-gray-500 font-medium truncate max-w-[65px] md:max-w-[80px] capitalize">
                                    {{ $item->location ?? 'Cirebon' }}
                                </span>
                            </div>
                            <span class="text-blue-600 font-bold text-[9px] md:text-[11px] whitespace-nowrap">Detail →</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-gray-500 italic text-sm">Belum ada barang.</div>
            @endforelse
        </div>
    </main>
@endsection