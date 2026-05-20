<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Preloved Kampus')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    {{-- Modal-modal ditaruh sekali saja di sini agar tidak duplikat --}}
    @include('partials.modal_jual')
    @include('partials.detail')

    <script>
        // --- LOGIC MODAL JUAL / EDIT ---
        function toggleModal() {
            const modal = document.getElementById('modalJual');
            if (modal) modal.classList.toggle('hidden');
        }

        function openAddModal() {
            const form = document.getElementById('formProduct');
            if (form) {
                form.reset();
                form.action = "/product";
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            }

            document.querySelector('#modalJual h3').innerText = 'Jual Barang';
            toggleModal();
        }

        function editProduct(item) {
            const modal = document.getElementById('modalJual');
            const form = document.getElementById('formProduct');

            form.action = "/product/" + item.id;

            if (!form.querySelector('input[name="_method"]')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_method';
                input.value = 'PUT';
                form.appendChild(input);
            }

            form.querySelector('input[name="name"]').value = item.name;
            form.querySelector('select[name="category"]').value = item.category;
            form.querySelector('input[name="price"]').value = item.price;
            form.querySelector('input[name="whatsapp_number"]').value = item.whatsapp_number;
            form.querySelector('input[name="location"]').value = item.location;
            form.querySelector('textarea[name="description"]').value = item.description || '';

            const soldContainer = document.getElementById('soldStatusContainer');
            const soldCheckbox = document.getElementById('is_sold_checkbox');

            if (soldContainer) {
                soldContainer.classList.remove('hidden');
                soldCheckbox.checked = item.is_sold == 1;
            }

            document.querySelector('#modalJual h3').innerText = 'Edit Barang';
            if (modal) modal.classList.remove('hidden');
        }

        // --- LOGIC MODAL DETAIL & WISHLIST ---
        window.showDetail = function(product) {
            if (event && (event.target.closest('button') || event.target.closest('form'))) {
                return;
            }

            if (!product) return;

            try {
                document.getElementById('detailName').innerText = product.name || '';
                document.getElementById('detailCategory').innerText = product.category || 'Umum';

                const rawPrice = product.price.toString().replace(/[^0-9]/g, '');
                document.getElementById('detailPrice').innerText = 'Rp ' + Number(rawPrice).toLocaleString('id-ID');

                document.getElementById('detailDescription').innerText = product.description || 'Tidak ada deskripsi.';
                document.getElementById('detailLocation').innerText = product.location || 'Cirebon';

                const userName = (product.user ? product.user.name : product.user_name) || 'Penjual';
                document.getElementById('detailUserName').innerText = userName;
                document.getElementById('detailUserInitial').innerText = userName.charAt(0).toUpperCase();

                const detailImg = document.getElementById('detailImage');
                detailImg.src = product.image.startsWith('http') ? product.image : `/storage/${product.image}`;

                const wishlistBtn = document.getElementById('modalWishlistBtn');
                const wishlistForm = document.getElementById('modalWishlistForm');

                if (wishlistBtn && wishlistForm) {
                    // FIX SINKRONISASI ROUTE: Menembak endpoint toggle database secara akurat
                    wishlistForm.action = `/wishlist/${product.id}`;

                    const currentUserId = {{ auth()->check() ? auth()->id() : 'null' }};

                    // FIX LOGIKA MERAH HATI: Toleran membaca status true dari halaman my-wishlist
                    const isWishlisted = product.is_liked === true || product.is_liked === 1 ||
                        (product.favorited_by ? product.favorited_by.some(u => u.id === currentUserId) : false) ||
                        (product.favoritedBy ? product.favoritedBy.some(u => u.id === currentUserId) : false);

                    if (isWishlisted) {
                        wishlistBtn.innerHTML =
                            `<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>`;
                        wishlistBtn.className =
                            "h-14 w-14 flex items-center justify-center rounded-2xl bg-red-50 border border-red-100 transition-all shadow-sm active:scale-90 flex-none";
                    } else {
                        wishlistBtn.innerHTML =
                            `<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>`;
                        wishlistBtn.className =
                            "h-14 w-14 flex items-center justify-center rounded-2xl bg-gray-50 border border-gray-100 transition-all shadow-sm active:scale-90 flex-none";
                    }
                }

                const waBtn = document.getElementById('detailWA');
                if (product.is_sold) {
                    waBtn.innerText = "Sudah Terjual";
                    waBtn.classList.add('bg-gray-400', 'pointer-events-none');
                    waBtn.classList.remove('bg-[#25D366]');
                    detailImg.classList.add('grayscale');
                } else {
                    waBtn.innerText = "Hubungi Penjual";
                    waBtn.classList.remove('bg-gray-400', 'pointer-events-none');
                    waBtn.classList.add('bg-[#25D366]');
                    detailImg.classList.remove('grayscale');

                    if (product.whatsapp_number) {
                        // 1. Bersihkan nomor HP dari karakter non-angka
                        const cleanNumber = product.whatsapp_number.replace(/[^0-9]/g, '');

                        // 2. Format teks siap kirim yang rapi dan detail
                        const textTemplate =
                            `Halo ${product.user_name || 'Kak'}, saya melihat produk "${product.name}" di Preloved Kampus. Apakah barangnya masih ada?`;

                        // 3. Ubah teks menjadi format URL-safe menggunakan encodeURIComponent
                        const message = encodeURIComponent(textTemplate);

                        // 4. Pasang ke atribut href tombol
                        waBtn.href = `https://wa.me/${cleanNumber}?text=${message}`;
                    }
                }

                const modal = document.getElementById('modalDetail');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

            } catch (e) {
                console.error("Error Detail:", e);
            }
        };

        // --- AUTO OPEN MODAL SETELAH WISHLIST (PENTING) ---
        document.addEventListener('DOMContentLoaded', function() {
            // FIX FLASH SESSION: Menangkap penamaan session 'openModalId' dari backend controller
            @if (session('openModal') || session('openModalId'))
                const products = @json($products ?? []);
                const productId = {{ session('openModal') ?? session('openModalId') }};
                const product = products.find(p => p.id === productId);
                if (product) {
                    showDetail(product);
                }
            @endif
        });

        // --- FUNGSI CLOSE DETAIL ---
        window.closeDetail = function() {
            const modal = document.getElementById('modalDetail');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };
    </script>
</body>

</html>
