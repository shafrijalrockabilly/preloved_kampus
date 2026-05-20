<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex flex-col gap-3">
        
        {{-- BARIS 1: Logo & Profil / Logout --}}
        <div class="flex justify-between items-center w-full">
            <a href="/" class="flex items-center gap-2 group">
                <div class="bg-blue-600 p-2 rounded-xl shadow-md shadow-blue-200 group-hover:rotate-6 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h1 class="text-base md:text-xl font-black tracking-tight text-blue-600 whitespace-nowrap">
                    Preloved<span class="text-gray-800">Kampus</span>
                </h1>
            </a>

            {{-- Profil & Tombol Jual di Sebelah Kanan --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- SHORTCUT MOBILE: Muncul di HP hanya jika akun adalah Admin --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                            class="md:hidden flex items-center gap-1 bg-blue-50 text-blue-600 px-2.5 py-1.5 rounded-xl text-xs font-black shadow-sm transition-all active:scale-95">
                            ⚙️ Admin
                        </a>
                    @endif

                    <button onclick="openAddModal()" 
                        class="flex items-center gap-1 bg-gray-900 hover:bg-blue-600 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-xl text-xs md:text-sm font-bold shadow-md transition-all active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-4 md:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Jual</span>
                    </button>

                    <a href="{{ route('profile.edit') }}" class="block">
                        <div class="h-8 w-8 md:h-9 md:w-9 rounded-full overflow-hidden bg-blue-100 border-2 border-white shadow-sm hover:scale-105 transition-transform">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-blue-600 font-bold text-xs uppercase">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 rounded-xl transition-all" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-xs md:text-sm font-bold text-gray-600 hover:text-blue-600 px-3 py-1.5">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs md:text-sm font-bold shadow-md transition-all active:scale-95">Daftar</a>
                @endguest
            </div>
        </div>

        {{-- BARIS 2: Kolom Pencarian (Full Width di Mobile) --}}
        <div class="w-full">
            <form action="/" method="GET" class="relative w-full group">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari kebutuhan kuliahmu..."
                    class="w-full bg-gray-100/70 border border-transparent rounded-2xl py-2 px-10 text-xs md:text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all duration-300">

                <div class="absolute left-3.5 top-2.5 md:top-3 text-gray-400 group-focus-within:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>

        {{-- BARIS 3: Menu Navigasi --}}
        @auth
            <div class="w-full flex items-center justify-start gap-1 overflow-x-auto no-scrollbar pt-1 border-t border-gray-50 md:border-none md:pt-0">
                <a href="/" class="px-3.5 py-1.5 rounded-xl text-xs md:text-sm font-bold whitespace-nowrap transition-all {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                    Beranda
                </a>
                <a href="{{ route('product.my') }}" class="px-3.5 py-1.5 rounded-xl text-xs md:text-sm font-bold whitespace-nowrap transition-all {{ request()->routeIs('product.my') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                    Barang Saya
                </a>
                <a href="{{ route('wishlist.index') }}" class="px-3.5 py-1.5 rounded-xl text-xs md:text-sm font-bold whitespace-nowrap transition-all {{ request()->routeIs('wishlist.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                    Wishlist Saya
                </a>

                {{-- SHORTCUT DESKTOP: Menyisipkan tombol dashboard ke deretan menu utama jika rolenya admin --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-1.5 rounded-xl text-xs md:text-sm font-black whitespace-nowrap transition-all {{ request()->is('admin/dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-red-50 hover:text-red-600' }}">
                        Panel Admin ⚙️
                    </a>
                @endif
            </div>
        @endauth

    </div>
</nav>