@extends('layouts.app')

@section('title', 'Beranda | Preloved Kampus')

@section('content')
    <header class="bg-white border-b border-gray-100 py-4 sticky top-0 z-10">
        <div class="container mx-auto px-4 flex gap-4 overflow-x-auto no-scrollbar">
            <a href="/"
                class="{{ !request('category') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }} px-5 py-1.5 rounded-full text-sm font-bold whitespace-nowrap transition-all">Semua</a>
            @php
                $categories = ['Buku Kuliah', 'Elektronik', 'Perkakas Kos', 'Fashion', 'Lainnya'];
            @endphp
            @foreach ($categories as $cat)
                <a href="/?category={{ $cat }}"
                    class="{{ request('category') == $cat ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }} px-5 py-1.5 rounded-full text-sm font-medium hover:bg-gray-200 whitespace-nowrap transition-all">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </header>

    <main class="container mx-auto px-4 py-10">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ request('search') ? 'Hasil Pencarian: "' . request('search') . '"' : (request('category') ? 'Kategori: ' . request('category') : 'Rekomendasi Hari Ini') }}
                </h2>
                <p class="text-gray-500 text-sm">Barang bekas berkualitas dari sesama mahasiswa.</p>
            </div>
            @if (request('category') || request('search'))
                <a href="/" class="text-blue-600 font-bold hover:underline text-sm">Hapus Filter</a>
            @endif
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse($products as $item)
                @php
                    // Kita siapkan data JSON di dalam variabel PHP agar rapi
                    $jsonItem = json_encode(
                        array_merge($item->toArray(), [
                            'user_name' => $item->user->name ?? 'Mahasiswa',
                        ]),
                    );
                @endphp

                {{-- Baris 42: Gunakan kutipan ganda (") untuk atribut, dan kutipan tunggal (') untuk isinya --}}
                <div data-product="{{ $jsonItem }}" onclick="showDetail(JSON.parse(this.getAttribute('data-product')))"
                    class="cursor-pointer bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all group relative">

                    <div class="relative">
                        <div class="h-44 bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="flex flex-col items-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <span
                            class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm text-blue-600 text-[10px] font-bold px-2 py-1 rounded-md shadow-sm uppercase">{{ $item->category }}</span>
                    </div>

                    <div class="p-4">
                        <h3
                            class="font-semibold text-gray-800 leading-tight line-clamp-2 h-10 group-hover:text-blue-600 transition-colors">
                            {{ $item->name }}</h3>
                        <p class="text-blue-600 font-extrabold text-lg mt-2">Rp
                            {{ number_format($item->price, 0, ',', '.') }}</p>

                        <div class="flex items-center gap-1 mt-2 text-gray-400">
                            <span class="text-[10px] italic line-clamp-1">📍
                                {{ $item->location ?? 'Sekitar Kampus' }}</span>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            @auth
                                @if (auth()->user()->role == 'admin' || auth()->id() == $item->user_id)
                                    {{-- Tombol Edit --}}
                                    <button type="button" data-item="{{ json_encode($item) }}"
                                        onclick="event.stopPropagation(); editProduct(JSON.parse(this.getAttribute('data-item')))"
                                        class="p-2 bg-yellow-50 text-yellow-600 rounded-xl hover:bg-yellow-600 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="/product/{{ $item->id }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus barang ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="event.stopPropagation()"
                                            class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            <div
                                class="flex-1 bg-gray-50 group-hover:bg-blue-600 group-hover:text-white text-gray-500 font-bold py-2 rounded-xl text-center transition-all text-[10px]">
                                Detail
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 italic font-medium">Belum ada barang yang dijual.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection
