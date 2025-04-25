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
                </div>

                <div class="menu-grid" id="menu-grid">
                    @foreach($products as $product)
                        <div class="menu-item" data-id="{{ $product->id }}" data-stock="{{ $product->stock }}"
                            data-category="{{ $product->category_id }}">

                            <div class="menu-item-image">
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" />
                                <div class="edit-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="menu-item-info">
                                <span class="menu-item-name">{{ $product->name }}</span>
                                <p class="menu-item-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="edit-actions">
                                <a href="{{ route('products.edit', $product->id) }}" class="edit-btn">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mb-1">Hapus</button>
                                </form>
y

                            </div>
                        </div>
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
                                <form method="POST" id="editProductForm">
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

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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



@endsection