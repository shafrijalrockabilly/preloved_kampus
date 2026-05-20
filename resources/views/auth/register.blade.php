<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Preloved Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50/50 min-h-screen flex flex-col justify-between">

    {{-- Top Simple Navbar --}}
    <header class="p-5 container mx-auto flex justify-between items-center">
        <a href="/" class="flex items-center gap-2">
            <div class="bg-blue-600 p-2 rounded-xl shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h1 class="text-lg font-black text-blue-600">Preloved<span class="text-gray-800">Kampus</span></h1>
        </a>
        <a href="/" class="text-xs font-bold text-gray-500 hover:text-blue-600">← Kembali ke Beranda</a>
    </header>

    {{-- Main Auth Card --}}
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-3xl border border-gray-100 shadow-sm p-8 md:p-10">
            
            {{-- Header Form --}}
            <div class="text-center mb-8">
                <div class="inline-flex bg-blue-600 p-3 rounded-2xl shadow-md shadow-blue-100 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Gabung Pasar Kampus</h2>
                <p class="text-sm text-gray-500 mt-1">Daftarkan akunmu untuk mulai bertransaksi sesama mahasiswa.</p>
            </div>

            {{-- Laravel Form Handler --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Full Name Field --}}
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Chafidz Shafrijal"
                        class="w-full bg-gray-50 border border-transparent rounded-xl py-3 px-4 text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all @error('name') border-red-500 bg-white @enderror">
                    @error('name')
                        <span class="text-xs font-semibold text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@stmik-ikmi.ac.id"
                        class="w-full bg-gray-50 border border-transparent rounded-xl py-3 px-4 text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all @error('email') border-red-500 bg-white @enderror">
                    @error('email')
                        <span class="text-xs font-semibold text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Kata Sandi</label>
                    <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full bg-gray-50 border border-transparent rounded-xl py-3 px-4 text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all @error('password') border-red-500 bg-white @enderror">
                    @error('password')
                        <span class="text-xs font-semibold text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password Confirmation Field --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                        class="w-full bg-gray-50 border border-transparent rounded-xl py-3 px-4 text-sm focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all">
                </div>

                {{-- Action Submit Button --}}
                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-md shadow-blue-100 transition-all active:scale-[0.98] mt-2">
                    Mulai Mendaftar
                </button>
            </form>

            {{-- Footer Login Link --}}
            <div class="text-center mt-8 pt-6 border-t border-gray-50">
                <p class="text-xs text-gray-500 font-medium">
                    Sudah terdaftar sebelumnya? 
                    <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk Akun</a>
                </p>
            </div>

        </div>
    </main>

    {{-- Footer Copyright --}}
    <footer class="py-4 text-center text-xs text-gray-400">
        &copy; 2026 Preloved Kampus. Made for College Marketplace.
    </footer>

</body>
</html>