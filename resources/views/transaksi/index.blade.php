@extends('layouts.app')

@push('styles')
<style>
    /* Kasir Specific Styles */
    body {
        margin-bottom: 30px;
    }
    
    .product-card {
        border: 1px solid var(--border-color);
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        background: var(--card-bg);
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(161, 140, 209, 0.2);
        border-color: var(--accent-purple);
    }
    .product-card:active {
        transform: translateY(-1px) scale(0.98);
        box-shadow: var(--shadow-sm);
    }
    
    @keyframes pulseGlow {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(248, 161, 196, 0.7); }
        50% { transform: scale(1.05); box-shadow: 0 0 15px 5px rgba(248, 161, 196, 0.4); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(248, 161, 196, 0); }
    }
    
    .pulse-glow {
        animation: pulseGlow 0.4s ease-out;
    }
    
    .product-img-wrapper {
        height: 150px;
        background-color: var(--input-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cart-wrapper {
        background: var(--card-bg);
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }
    
    .cart-item {
        border-bottom: 1px dashed var(--border-color);
        transition: all 0.2s ease;
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .qty-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 14px;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        background: var(--input-bg);
        transition: 0.2s;
    }
    
    .qty-btn:hover {
        background: var(--primary-pink);
        color: var(--text-color);
    }
    
    .qty-input {
        width: 40px;
        border: none;
        text-align: center;
        font-weight: 500;
        background: transparent;
        color: var(--text-color);
    }
    
    .search-input {
        border-radius: 20px;
        border: 1px solid var(--border-color);
        padding-left: 40px;
        background: var(--input-bg);
        color: var(--text-color);
    }
    
    .search-wrapper {
        position: relative;
    }
    
    .search-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .empty-cart-state {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-color);
    }
    
    .empty-cart-state i {
        color: var(--accent-purple);
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
        display: block;
    }
    .empty-cart-state h6 {
        font-family: 'Playfair Display', serif;
        color: var(--text-color);
    }
    .empty-cart-state p {
        max-width: 220px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .btn-checkout {
        background: linear-gradient(135deg, var(--gold-accent), #c29929);
        color: white;
        border-radius: 20px;
        font-weight: 500;
        border: none;
        padding: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
    }
    
    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
        color: white;
    }
    .btn-checkout:disabled {
        background: var(--border-color);
        color: var(--text-muted);
        box-shadow: none;
    }

    /* Custom Toast */
    .swal2-toast {
        background: var(--card-bg) !important;
        color: var(--text-color) !important;
        box-shadow: var(--shadow-md) !important;
        border-radius: 14px !important;
        border-left: 4px solid var(--accent-purple) !important;
        font-family: 'Poppins', sans-serif !important;
    }
    .swal2-timer-progress-bar {
        background: linear-gradient(90deg, var(--primary-pink), var(--accent-purple)) !important;
    }

    /* Print Layout Minimal Kasir */
    @media print {
        body * {
            visibility: hidden;
            border: none;
            box-shadow: none;
        }
        body {
            background-color: white !important;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            font-family: 'Poppins', Courier, monospace;
        }
        .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="row g-4 mt-1">
    <!-- Kiri: Gallery Produk -->
    <div class="col-lg-7 fade-in">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h5 class="mb-0 fw-bold brand-font" style="color: var(--text-color)"><i class="fa-solid fa-store me-2" style="color: var(--accent-pink)"></i> Produk Kosmetik</h5>
            
            <div class="d-flex gap-2 align-items-center">
                <select class="form-select border-0 shadow-sm rounded-pill" id="catFilter" style="width: auto; font-size: 0.9rem;">
                    <option value="all">Semua Kategori</option>
                    <option value="Skincare">Skincare</option>
                    <option value="Makeup">Makeup</option>
                    <option value="Bodycare">Bodycare</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <select class="form-select border-0 shadow-sm rounded-pill" id="sortFilter" style="width: auto; max-width: 150px; font-size: 0.9rem;">
                    <option value="all">Saring</option>
                    <option value="cheap">Termurah</option>
                    <option value="expensive">Termahal</option>
                    <option value="instock">Ada Stok</option>
                </select>
                
                <div class="search-wrapper" style="width: 200px;">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchBarang" class="form-control search-input shadow-sm" placeholder="Search...">
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-3 g-3 mb-4" id="productGrid">
            @forelse($barangs as $item)
            <div class="col product-col" data-kategori="{{ $item->kategori }}">
                <div class="product-card h-100 shadow-sm" onclick="addToCart({{ $item->id }}, '{{ addslashes($item->nama_barang) }}', {{ $item->harga }}, {{ $item->stok }}, '{{ $item->gambar ? asset($item->gambar) : '' }}')">
                    <div class="product-img-wrapper">
                        @if($item->gambar)
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_barang }}" loading="lazy">
                        @else
                            <i class="fa-solid fa-box fa-3x" style="color: var(--primary-pink); opacity: 0.5;"></i>
                        @endif
                    </div>
                    <div class="card-body p-3 text-center">
                        <h6 class="mb-1 text-truncate fw-bold item-name" style="font-size: 0.9rem; color: var(--text-color);" title="{{ $item->nama_barang }}">
                            {{ $item->nama_barang }}
                        </h6>
                        <p class="mb-1 fw-bold item-harga" data-raw="{{ $item->harga }}" style="color: var(--accent-pink); font-size: 0.95rem;">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>
                        <small class="text-muted" style="font-size: 0.75rem;">Stok: <span id="stok-{{ $item->id }}" class="item-stok">{{ $item->stok }}</span></small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5 px-3" style="opacity: 0.7;">
                    <i class="fa-solid fa-store fa-3x mb-3" style="color: var(--accent-purple); opacity: 0.5;"></i>
                    <h6 class="fw-bold brand-font" style="color: var(--text-color)">Belum Ada Produk</h6>
                    <p class="text-muted small" style="max-width: 260px; margin: 0 auto;">Tambahkan produk skincare & makeup dari menu <strong>Produk</strong> untuk mulai berjualan.</p>
                    <a href="{{ route('barang.create') }}" class="btn btn-custom btn-sm mt-3 px-4">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Produk
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Kanan: Shopping Cart -->
    <div class="col-lg-5 fade-in">
        <div class="cart-wrapper p-4 h-100 sticky-lg-top" style="top: 80px; z-index: 10;">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <div>
                    <h5 class="fw-bold mb-0 brand-font" style="color: var(--text-color)"><i class="fa-solid fa-basket-shopping me-2" style="color: var(--accent-pink)"></i> Keranjang</h5>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge shadow-sm rounded-pill border px-3 py-2" id="cart-count" style="background: var(--input-bg); color: var(--text-color);">0 Item</span>
                    <button class="btn btn-sm text-danger border-0 p-0 shadow-none" onclick="clearCart()" title="Kosongkan Keranjang"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>

            <div class="empty-cart-state" id="empty-cart">
                <i class="fa-solid fa-bag-shopping"></i>
                <h6 class="fw-bold">Keranjang Kosong!</h6>
                <p class="text-muted small">Pilih makeup atau skincare kesukaanmu dari daftar di sebelah kiri yuk!</p>
            </div>

            <div class="cart-items-container" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;" id="cart-container">
                <!-- Cart items rendered here via JS -->
            </div>

            <div class="mt-4 pt-3 border-top position-relative" style="background: transparent;">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-muted fw-semibold">Subtotal</span>
                    <span class="fw-bold" id="cart-subtotal" style="color: var(--text-color)">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5" style="color: var(--accent-pink)">Total Bayar</span>
                    <span class="fw-bold fs-4" id="cart-total" style="color: var(--accent-pink)">Rp 0</span>
                </div>

                <div class="row g-2">
                    <div class="col-12">
                        <button class="btn btn-custom w-100 shadow-sm" id="btn-process" disabled>
                            <i class="fa-solid fa-check-circle me-1"></i> Proses Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Area Default Hidden -->
<div id="print-area" class="d-none">
    <div class="text-center mb-3">
        <img src="{{ asset('images/logo.png') }}" style="width: 50px; height: auto; margin-bottom: 5px;">
        <h3 class="fw-bold mb-0" style="font-family: 'Playfair Display', serif;">NESYÈL CLARITÉ</h3>
        <p class="small mb-0">Premium Beauty & Skincare</p>
        <p class="small text-muted" id="print-date"></p>
        <div style="border-top: 1px dashed #333; margin: 10px 0;"></div>
    </div>
    
    <div id="print-items"></div>
    
    <div style="border-top: 1px dashed #333; margin: 10px 0;"></div>
    <div class="d-flex justify-content-between fw-bold">
        <span>TOTAL</span>
        <span id="print-total"></span>
    </div>
    <div class="text-center mt-4 pt-2">
        <p class="small">Terima Kasih Atas Kunjungan Anda<br>Barang yang sudah dibeli tidak dapat ditukar.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let cart = {};
    const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    // Toast Notification Maker
    const showToast = (icon, title) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }

    // Advanced Search & Filter
    function applyFilters() {
        let searchValue = document.getElementById('searchBarang').value.toLowerCase();
        let sortValue = document.getElementById('sortFilter').value;
        let catValue = document.getElementById('catFilter').value;
        let items = Array.from(document.querySelectorAll('.product-col'));
        let grid = document.getElementById('productGrid');
        
        // Sorting Logic
        if (sortValue === 'cheap' || sortValue === 'expensive') {
            items.sort((a, b) => {
                let priceA = parseInt(a.querySelector('.item-harga').getAttribute('data-raw'));
                let priceB = parseInt(b.querySelector('.item-harga').getAttribute('data-raw'));
                return sortValue === 'cheap' ? priceA - priceB : priceB - priceA;
            });
            items.forEach(item => grid.appendChild(item));
        }
        
        // Filtering Logic
        items.forEach(function(item) {
            let name = item.querySelector('.item-name').innerText.toLowerCase();
            let stock = parseInt(item.querySelector('.item-stok').innerText);
            let itemCat = item.getAttribute('data-kategori') || 'Lainnya';
            
            let matchesSearch = name.indexOf(searchValue) > -1;
            let matchesStock = sortValue !== 'instock' || stock > 0;
            let matchesCat = catValue === 'all' || itemCat === catValue;
            
            if(matchesSearch && matchesStock && matchesCat) {
                item.style.display = 'block';
                item.classList.add('fade-in');
            } else {
                item.style.display = 'none';
                item.classList.remove('fade-in');
            }
        });
    }

    document.getElementById('searchBarang').addEventListener('keyup', applyFilters);
    document.getElementById('sortFilter').addEventListener('change', applyFilters);
    document.getElementById('catFilter').addEventListener('change', applyFilters);

    window.clearCart = function() {
        if(Object.keys(cart).length === 0) return;
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: "Apakah kamu yakin ingin menghapus semua item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, hapus!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                cart = {};
                updateCartUI();
                showToast('info', 'Keranjang dikosongkan!');
            }
        });
    }

    // Add to Cart from Card Click
    window.addToCart = function(id, nama, harga, maxStok, image) {
        if (maxStok <= 0) {
            showToast('error', 'Stok produk habis!');
            return;
        }

        // Highlight animation
        let card = event.currentTarget;
        card.classList.add('pulse-glow');
        setTimeout(() => card.classList.remove('pulse-glow'), 400);

        if (cart[id]) {
            if (cart[id].qty + 1 > maxStok) {
                showToast('error', 'Maksimal stok tercapai!');
                return;
            }
            cart[id].qty++;
        } else {
            cart[id] = { id, nama, harga, maxStok, image, qty: 1 };
        }
        
        showToast('success', 'Produk ditambahkan! 💅');
        updateCartUI();
    };

    // Update Qty from Cart
    window.updateQty = function(id, action) {
        if (!cart[id]) return;

        if (action === 'plus') {
            if (cart[id].qty + 1 > cart[id].maxStok) {
                showToast('warning', 'Melebihi sisa stok!');
                return;
            }
            cart[id].qty++;
        } else if (action === 'minus') {
            if (cart[id].qty - 1 <= 0) {
                delete cart[id];
            } else {
                cart[id].qty--;
            }
        }
        
        updateCartUI();
    };

    // Remove Item
    window.removeItem = function(id) {
        if (cart[id]) {
            delete cart[id];
            updateCartUI();
            showToast('success', 'Produk dihapus!');
        }
    }

    // Render Cart Element
    function updateCartUI() {
        let container = document.getElementById('cart-container');
        let emptyState = document.getElementById('empty-cart');
        let keys = Object.keys(cart);
        let totalQty = 0;
        let grandTotal = 0;
        
        container.innerHTML = '';

        if (keys.length === 0) {
            emptyState.style.display = 'block';
            document.getElementById('btn-process').disabled = true;
            document.getElementById('cart-subtotal').innerText = 'Rp 0';
            document.getElementById('cart-total').innerText = 'Rp 0';
            document.getElementById('cart-count').innerText = '0 Item';
            return;
        }

        emptyState.style.display = 'none';
        
        keys.forEach(key => {
            let item = cart[key];
            let itemTotal = item.harga * item.qty;
            grandTotal += itemTotal;
            totalQty += item.qty;

            let imgHtml = item.image 
                ? `<img src="${item.image}" alt="${item.nama}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">`
                : `<div class="rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; background: var(--input-bg); border: 1px solid var(--border-color);"><i class="fa-solid fa-box text-muted"></i></div>`;

            let div = document.createElement('div');
            div.className = 'cart-item d-flex align-items-center justify-content-between py-2';
            div.innerHTML = `
                <div class="d-flex align-items-center gap-2" style="max-width: 50%;">
                    ${imgHtml}
                    <div>
                        <h6 class="mb-0 fw-bold text-truncate" style="font-size: 0.85rem;" title="${item.nama}">${item.nama}</h6>
                        <small class="text-muted">${formatRupiah(item.harga)}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center rounded-pill px-2 py-1 me-2 shadow-sm border" style="background: var(--card-bg); border-color: var(--border-color) !important;">
                        <button class="qty-btn" onclick="updateQty(${item.id}, 'minus')"><i class="fa-solid fa-minus"></i></button>
                        <input type="text" class="qty-input" value="${item.qty}" readonly>
                        <button class="qty-btn" onclick="updateQty(${item.id}, 'plus')"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: var(--accent-pink); font-size: 0.85rem;">${formatRupiah(itemTotal)}</div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('cart-subtotal').innerText = formatRupiah(grandTotal);
        document.getElementById('cart-total').innerText = formatRupiah(grandTotal);
        document.getElementById('cart-count').innerText = totalQty + ' Item';
        
        let btnProcess = document.getElementById('btn-process');
        btnProcess.disabled = false;
        btnProcess.setAttribute('data-total', grandTotal);
    }

    // Awal init cart state
    updateCartUI();

    // Process Transaction
    document.getElementById('btn-process').addEventListener('click', function() {
        let total = this.getAttribute('data-total');
        
        let cartArray = Object.values(cart).map(i => ({
            id: i.id,
            qty: i.qty
        }));

        Swal.fire({
            title: 'Selesaikan Transaksi?',
            text: "Total pembayaran " + formatRupiah(total),
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d1829e',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Bayar!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing... ✨',
                    html: '<div style="margin: 20px 0"><div class="spinner-border" style="color: var(--accent-purple); width: 3rem; height: 3rem;"></div></div><p class="text-muted" style="font-size: 0.9rem;">Tunggu sebentar, pesanan sedang diproses...</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)',
                    color: 'var(--text-color)'
                });

                fetch('{{ route('transaksi.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        items: cartArray,
                        total: total
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pembayaran Berhasil! 🎉',
                            html: `<p>Kembalian: Rp 0 (Uang Pas)</p><button class="btn btn-outline-secondary btn-sm mt-2" onclick="printStruk()"><i class="fa-solid fa-print"></i> Cetak Struk</button>`,
                            showConfirmButton: true,
                            confirmButtonColor: '#d1829e',
                            confirmButtonText: 'Selesai'
                        }).then(() => {
                            cart = {};
                            updateCartUI();
                            
                            // Skeleton loading for product grid
                            let productGrid = document.getElementById('productGrid');
                            productGrid.innerHTML = Array(6).fill(`
                                <div class="col product-col">
                                    <div class="product-card h-100 shadow-sm">
                                        <div class="skeleton" style="height: 150px; border-radius: 18px 18px 0 0;"></div>
                                        <div class="card-body p-3 text-center">
                                            <div class="skeleton mx-auto mb-2" style="height: 14px; width: 80%;"></div>
                                            <div class="skeleton mx-auto mb-2" style="height: 16px; width: 50%;"></div>
                                            <div class="skeleton mx-auto" style="height: 12px; width: 40%;"></div>
                                        </div>
                                    </div>
                                </div>
                            `).join('');
                            
                            // AJAX Reload Ringan (DOM fetch parsing)
                            fetch(window.location.href)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                productGrid.innerHTML = doc.getElementById('productGrid').innerHTML;
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oppss!',
                            text: data.message || 'Terjadi kesalahan'
                        });
                    }
                }).catch(err => {
                    Swal.fire('Error', 'Gagal memproses transaksi.', 'error');
                });
            }
        });
    });

    // Fitur Print Struk
    window.printStruk = function() {
        showToast('info', 'Mencetak struk...');
        
        let printItems = document.getElementById('print-items');
        let printTotal = document.getElementById('print-total');
        let printDate = document.getElementById('print-date');
        
        printDate.innerText = new Date().toLocaleString('id-ID');
        printItems.innerHTML = '';
        
        let total = 0;
        Object.values(cart).forEach(item => {
            let subtotal = item.qty * item.harga;
            total += subtotal;
            
            printItems.innerHTML += `
                <div class="d-flex justify-content-between small">
                    <span class="text-truncate" style="max-width: 150px;">${item.nama}</span>
                    <span>${item.qty}x</span>
                </div>
                <div class="text-end small text-muted mb-1">${formatRupiah(subtotal)}</div>
            `;
        });
        
        printTotal.innerText = formatRupiah(total);
        
        setTimeout(() => {
            window.print();
        }, 500);
    }
</script>
@endpush
