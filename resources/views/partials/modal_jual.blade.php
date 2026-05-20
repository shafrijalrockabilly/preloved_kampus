<div id="modalJual" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 animate-[fadeIn_0.3s_ease-out]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Jual Barang</h3>
                <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="formProduct" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Barang</label>
                        <input type="text" name="name" required placeholder="Contoh: Kalkulator Casio"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <select name="category"
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Buku Kuliah">Buku Kuliah</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Perkakas Kos">Perkakas Kos</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="price" required placeholder="Contoh: 85000"
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Barang</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer bg-gray-50 border border-gray-200 rounded-xl p-1">
                        <p class="text-[10px] text-gray-400 mt-1">*Maksimal ukuran foto 2MB</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp (Awali 62)</label>
                        <input type="text" name="whatsapp_number" required placeholder="628123456xxx"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                        <textarea name="description" rows="3" placeholder="Contoh: Kondisi 95% mulus, jarang dipakai, nego tipis..."
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" placeholder="Contoh: Depan Gerbang IKMI"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- FITUR BARU: TOGGLE SOLD (Hanya muncul saat Edit) --}}
                    <div id="soldStatusContainer" class="hidden mt-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-bold text-blue-900">Status Penjualan</label>
                                <p class="text-[10px] text-blue-700">Centang jika barang sudah terjual/laku</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_sold" id="is_sold_checkbox" value="1"
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-8 bg-blue-600 text-white font-bold py-3 rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-95">
                    Posting Barang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('modalJual');
        modal.classList.toggle('hidden');
    }

    function openModalJual() {
        const modal = document.getElementById('modalJual');
        const form = document.getElementById('formProduct');
        
        // 1. Reset isi form agar kosong
        form.reset();
        
        // 2. Pastikan action form mengarah ke route store (tambah barang)
        form.action = "{{ route('product.store') }}"; 
        
        // 3. Hapus input spoofing _method PUT (jika ada bekas sisa Edit)
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        // 4. Sembunyikan opsi "Sold" karena ini barang baru
        const soldContainer = document.getElementById('soldStatusContainer');
        if (soldContainer) soldContainer.classList.add('hidden');

        // 5. Ubah teks Header Modal
        const modalTitle = document.querySelector('#modalJual h3');
        if (modalTitle) modalTitle.innerText = 'Jual Barang Baru';

        // 6. Tampilkan Modal
        modal.classList.remove('hidden');
    }
</script>
