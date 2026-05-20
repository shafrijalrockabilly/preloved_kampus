@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#F8FAFC] py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 text-center">
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Pengaturan <span
                        class="text-blue-600">Profil</span></h2>
                <p class="text-gray-500 mt-2 font-medium text-lg">Kelola informasi akun Anda di Preloved Kampus.</p>
            </div>

            <div class="space-y-8">
                <div
                    class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf
                        @method('patch')

                        {{-- Section Avatar - Lingkaran Sempurna --}}
                        <div class="flex flex-col items-center">
                            <div class="relative group">
                                {{-- Container Utama Lingkaran --}}
                                <div
                                    class="h-32 w-32 rounded-full overflow-hidden border-4 border-white shadow-2xl bg-blue-100 relative">
                                    @if (auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" id="preview-avatar"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div id="placeholder-avatar"
                                            class="w-full h-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-5xl font-black">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Button Upload Avatar (Bulat) --}}
                                <label for="avatar-input"
                                    class="absolute bottom-0 right-0 bg-white p-3 rounded-full shadow-xl border border-gray-100 cursor-pointer hover:scale-110 transition-transform text-blue-600 z-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*"
                                        onchange="previewProfileImage(event)">
                                </label>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-4 font-bold uppercase tracking-widest">Ketuk ikon kamera
                                untuk ubah foto</p>
                        </div>

                        {{-- Form Fields --}}
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:bg-white outline-none transition-all font-medium">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Kampus</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:bg-white outline-none transition-all font-medium">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 text-lg">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Section Update Password --}}
                <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Keamanan Kata Sandi</h3>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewProfileImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.getElementById('preview-avatar');
                    const placeholder = document.getElementById('placeholder-avatar');

                    if (preview) {
                        preview.src = e.target.result;
                    } else if (placeholder) {
                        const img = document.createElement('img');
                        img.id = 'preview-avatar';
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover animate-[fadeIn_0.3s]';
                        placeholder.parentElement.appendChild(img);
                        placeholder.remove();
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
