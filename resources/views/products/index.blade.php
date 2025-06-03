@extends('app')

@section('content')
    <div class="layout">
        <main class="main-content">
            <div class="menu-container">
                <div class="menu-header">
                    <div class="breadcrumb" style="text-decoration: none;">
                        <div class="header-wrapper">
                            <span>Pages</span>
                            <span class="separator">/</span>
                            <span style="color: white">Products</span>
                        </div>

                        <div class="search-container">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="search-input" placeholder="Search Menu" class="search-input" />
                        </div>
                    </div>

                    <div class="menu-title-container" style="text-decoration: none;">
                        <h1 class="menu-title" style="text-decoration: none;">Menu</h1>
                    </div>
                    @if (Auth::user() && Auth::user()->role === 'admin')
                        <div class="menu-button" style="cursor: pointer;">
                            <a class="add-menu-btn" style="text-decoration: none;" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Tambah Produk</span>
                            </a>
                            <button id="toggle-edit-mode" class="edit-menu-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                </svg>
                                <span>Edit Produk</span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Order Sidebar -->
                @if (Auth::user() && Auth::user()->role === 'kasir')
                    <button id="orderButton" onclick="toggleOrderSidebar()" class="button-order">🛒</button>
                @endif
                <div class="category-container flex gap-2 overflow-x-auto p-2 bg-gray-100 rounded-md">
                    @foreach($categories as $category)
                        <button class="category-list" data-category-id="{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="menu-grid" id="menu-grid">
                    @foreach($products as $product)
                        @if($product->stock > 0) <!-- Produk hanya ditampilkan jika stok lebih dari 0 -->
                            <div class="menu-item" data-id="{{ $product->id}}" data-stock="{{ $product->stock }}"
                                data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}"
                                onclick="addToOrder({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">

                                <div class="menu-item-image">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                                        onclick="addToOrder({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" />
                                    <!-- ... tombol edit & hapus tetap ditampilkan di admin -->
                                    <div class="edit-icon">
                                        <!-- SVG Edit Icon -->
                                    </div>
                                    <div class="edit-actions">
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-delete-products" type="button" onclick="konfirmasiHapus(this)">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6"
                                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="menu-item-info">
                                    <span class="menu-item-name">{{ $product->name }}</span>
                                    <div class="info-container">
                                        <p class="menu-item-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="menu-item-price">Stok: {{ $product->stock }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


                <!-- Modal Edit Produk -->
                <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="editProductForm" enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" id="edit-id">

                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" name="name" id="edit-name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Harga</label>
                                        <input type="number" step="0.01" name="price" id="edit-price" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" name="stock" id="edit-stock" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="category_id" id="edit-category" class="form-select" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="color: black;">Gambar Produk</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    </div>
                                    @if(session('success'))
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Berhasil!',
                                                    text: '{{ session('success') }}',
                                                    timer: 2000,
                                                    showConfirmButton: false
                                                });
                                            });
                                        </script>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="order-sidebar" class="order-sidebar"
                style="display:none; position:fixed; right:0; top:0; width:300px; height:100%; background:#fff; border-left:1px solid #ccc; padding:20px; overflow-y:auto; z-index:1000;">
                <div class="order-header-text">
                    <button id="backButton"><svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg></button>
                    <h5 style="color: black;">Order</h5>
                </div>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form style="justify-content: center; align-items: center;" class="form-order" method="POST"
                    action="{{ route('transactions.store') }}">
                    @csrf
                    <!-- Add Product Button -->
                    <button type="button" class="button-add-item" data-bs-toggle="modal"
                        data-bs-target="#productSelectionModal"> <svg xmlns="http://www.w3.org/2000/svg" width="40"
                            height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg></button>
                    <div class="scrollable-products">
                        <div class="list-order">
                            <div id="products-wrapper">
                                <div id="empty-message">
                                    <p style="margin-left: 12px;">Belum ada item</p>
                                </div>
                                <!-- product-row akan ditambahkan di sini -->
                            </div>
                        </div>
                    </div>
                    <div class="payment-form">
                        <hr class="divider">

                        <div class="form-group">
                            <span for="total_amount_sidebar">Total Harga</span>
                            <input type="text" id="total_amount_sidebar" class="form-control" readonly>
                        </div>
                        <!-- Paid Amount Field -->
                        <div class="jml-bayar">
                            <span for="paid_amount">Jumlah Bayar</span>
                            <input type="number" name="paid_amount" id="paid_amount_sidebar" class="form-control" required
                                min="0">
                        </div>

                        <!-- Submit Order Button -->
                        <div class="btn-submit-order">
                            <button type="submit" class="btn-transaction" id="submitTransactionBtn">Simpan
                                Transaksi</button>

                        </div>

                    </div>
                </form>
            </div>
        </main>


    </div>
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="color: black;">Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: black;">Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: black;">Stok</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: black;">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: black;">Gambar Produk</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Daftar Produk -->
    <div class="modal fade" id="productSelectionModal" tabindex="-1" aria-labelledby="productSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productSelectionModalLabel">Pilih Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="products-modal-row" id="product-selection-container">
                        <!-- Produk akan dimuat di sini -->
                        @foreach($products as $product)
                            <div class="col-md-3 mb-3 product-item" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock }}">
                                <div class="product-card" style="cursor: pointer;">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" />
                                    <div class="text-center">
                                        <h6>{{ $product->name }}</h6>
                                        <p>Rp {{ number_format($product->price, 0) }}</p>
                                        <small>Stok: {{ $product->stock }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            opacity: 1;
        }

        .qty-input {
            color: #2A2A56;
            border: none;
            font-weight: 600;
        }
    </style>

    {{-- CSS dan JS --}}
    <style>
        .edit-icon {
            position: absolute;
            top: 8px;
            left: 8px;
            display: none;
        }

        .menu-item.edit-mode .edit-icon {
            display: block;
        }

        .edit-actions {
            display: none;
            margin-top: 10px;
        }

        .menu-item.edit-mode .edit-actions {
            display: block;
        }
    </style>
    <script>
        const toggleEditBtn = document.getElementById('toggle-edit-mode');
        const items = document.querySelectorAll('.menu-item');
        let editMode = false;

        toggleEditBtn.addEventListener('click', () => {
            editMode = !editMode;
            items.forEach(item => item.classList.toggle('edit-mode', editMode));
        });

        items.forEach(item => {
            item.addEventListener('click', (e) => {
                if (!editMode) return;
                e.preventDefault();

                // Jika klik berasal dari tombol edit/hapus, jangan lanjutkan
                if (e.target.closest('.edit-actions')) return;

                const id = item.dataset.id;
                const name = item.querySelector('.menu-item-name').innerText.trim();
                const priceText = item.querySelector('.menu-item-price').innerText.trim();
                const price = priceText.replace(/[^\d]/g, '');
                const stock = item.dataset.stock;
                const category = item.dataset.category;

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-price').value = price;
                document.getElementById('edit-stock').value = stock;
                document.getElementById('edit-category').value = category;

                document.getElementById('editProductForm').action = `/products/${id}`;

                new bootstrap.Modal(document.getElementById('editProductModal')).show();
            });

            // Tambahkan ini untuk mencegah bubble dari tombol edit/hapus
            item.querySelectorAll('.edit-btn, form button').forEach(btn => {
                btn.addEventListener('click', e => e.stopPropagation());
            });
        });

    </script>
    @if(session('transaksi_berhasil') && session('transaction_id'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Transaksi berhasil!',
                text: 'Apakah Anda ingin mencetak struk?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Print Receipt',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("{{ route('transactions.receipt', session('transaction_id')) }}", '_blank');
                } else {
                    // Tidak melakukan apa-apa, tetap di halaman ini
                }
            });
        </script>
    @endif


@endsection