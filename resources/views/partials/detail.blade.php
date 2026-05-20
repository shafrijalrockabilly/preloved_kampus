<div id="modalDetail" class="fixed inset-0 z-[70] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDetail()"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden relative z-10 flex flex-col md:flex-row animate-[fadeIn_0.3s]">

            <div class="md:w-1/2 bg-gray-100 flex items-center justify-center overflow-hidden relative">
                <img id="detailImage" src="" alt="" class="w-full h-full object-cover transition-all duration-500">
                <div id="soldOverlay" class="absolute inset-0 bg-black/40 hidden items-center justify-center">
                    <span class="bg-red-600 text-white text-xs font-black px-4 py-2 rounded-xl uppercase rotate-[-10deg] shadow-lg">Terjual</span>
                </div>
            </div>

            <div class="md:w-1/2 p-8 relative flex flex-col bg-white">
                <button type="button" onclick="closeDetail()"
                    class="absolute top-4 right-4 z-50 p-2 bg-gray-50 hover:bg-gray-200 rounded-full transition-all active:scale-90">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="mb-1">
                    <span id="detailCategory"
                        class="text-blue-600 text-[10px] font-black uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-xl shadow-sm"></span>
                </div>
                <h3 id="detailName" class="text-2xl font-black text-gray-900 mt-2 leading-tight"></h3>
                <p id="detailPrice" class="text-xl font-black text-blue-600 mt-1"></p>

                <hr class="my-5 border-gray-100">

                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-100 mb-6">
                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-black shadow-sm overflow-hidden">
                        <span id="detailUserInitial"></span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase leading-none">Penjual</p>
                        <p id="detailUserName" class="text-sm font-black text-gray-800 mt-1"></p>
                    </div>
                </div>

                <div class="space-y-5 flex-grow">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">📍 Lokasi</p>
                        <p id="detailLocation" class="text-gray-700 text-sm font-bold"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">📝 Deskripsi</p>
                        <div class="max-h-32 overflow-y-auto">
                            <p id="detailDescription" class="text-gray-600 text-sm leading-relaxed font-medium"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    @auth
                        <form id="modalWishlistForm" method="POST" class="flex-none">
                            @csrf
                            <button type="submit" id="modalWishlistBtn" 
                                class="h-14 w-14 flex items-center justify-center rounded-2xl transition-all shadow-lg active:scale-95 border border-gray-100 bg-gray-50 hover:bg-white group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                            class="h-14 w-14 flex items-center justify-center rounded-2xl bg-gray-50 text-gray-300 border border-gray-100 shadow-sm transition-all hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                    @endauth

                    <a id="detailWA" href="" target="_blank"
                        class="flex-1 flex items-center justify-center gap-2 bg-[#25D366] text-white py-4 rounded-2xl font-black hover:bg-[#128C7E] transition-all shadow-xl active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 0 5.414 0 12.05c0 2.123.555 4.197 1.608 6.013L0 24l6.135-1.61a11.787 11.787 0 005.911 1.583h.005c6.634 0 12.048-5.414 12.048-12.05a11.75 11.75 0 00-3.526-8.498z" />
                        </svg>
                        Hubungi Penjual
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>