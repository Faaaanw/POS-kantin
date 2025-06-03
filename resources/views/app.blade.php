<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lio Mart</title>
  <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/layout.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/sidebar.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/menu.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/order.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/animations.css')}} " />
  <link rel="stylesheet" href="{{asset('assets/css/home.css')}} " />
  <link rel="stylesheet" href="{{asset('assets/css/admin-user.css')}} " />
  <link rel="stylesheet" href="{{asset('assets/css/month.css')}} " />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">

  <script src="{{ asset('assets/js/order.js') }}"></script>
  <!-- Tambahkan ini di bagian <head> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tambahkan ini sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <script>
   document.addEventListener('DOMContentLoaded', function () {
  const categoryButtons = document.querySelectorAll('.category-list');
  const menuItems = document.querySelectorAll('.menu-item');
  let activeCategoryId = null;

  categoryButtons.forEach(button => {
    button.addEventListener('click', function () {
      const selectedId = this.dataset.categoryId;

      if (activeCategoryId === selectedId) {
        // Klik ulang = nonaktifkan filter
        activeCategoryId = null;
        menuItems.forEach(item => item.style.display = 'block');
        categoryButtons.forEach(btn => btn.classList.remove('active')); // pakai class 'active'
      } else {
        // Aktifkan filter
        activeCategoryId = selectedId;
        menuItems.forEach(item => {
          item.style.display = item.dataset.category === selectedId ? 'flex' : 'none';

        });

        // Highlight kategori aktif pakai class 'active'
        categoryButtons.forEach(btn => {
          if (btn.dataset.categoryId === selectedId) {
            btn.classList.add('active');
          } else {
            btn.classList.remove('active');
          }
        });
      }
    });
  });
});

  </script>

</head>

<body>
  <!-- Login/Logout Top Right -->
  <div class="auth-buttons position-absolute bottom-0 start-0 m-4">
    @guest
    <a href="{{ route('login') }}"><button class="button-login">
      <svg width="27" height="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
        d="M14.9453 1.25C13.5778 1.24998 12.4754 1.24996 11.6085 1.36652C10.7084 1.48754 9.95048 1.74643 9.34857 2.34835C8.82363 2.87328 8.55839 3.51836 8.41916 4.27635C8.28387 5.01291 8.25799 5.9143 8.25196 6.99583C8.24966 7.41003 8.58357 7.74768 8.99778 7.74999C9.41199 7.7523 9.74964 7.41838 9.75194 7.00418C9.75803 5.91068 9.78643 5.1356 9.89448 4.54735C9.99859 3.98054 10.1658 3.65246 10.4092 3.40901C10.686 3.13225 11.0746 2.9518 11.8083 2.85315C12.5637 2.75159 13.5648 2.75 15.0002 2.75H16.0002C17.4356 2.75 18.4367 2.75159 19.1921 2.85315C19.9259 2.9518 20.3144 3.13225 20.5912 3.40901C20.868 3.68577 21.0484 4.07435 21.1471 4.80812C21.2486 5.56347 21.2502 6.56459 21.2502 8V16C21.2502 17.4354 21.2486 18.4365 21.1471 19.1919C21.0484 19.9257 20.868 20.3142 20.5912 20.591C20.3144 20.8678 19.9259 21.0482 19.1921 21.1469C18.4367 21.2484 17.4356 21.25 16.0002 21.25H15.0002C13.5648 21.25 12.5637 21.2484 11.8083 21.1469C11.0746 21.0482 10.686 20.8678 10.4092 20.591C10.1658 20.3475 9.99859 20.0195 9.89448 19.4527C9.78643 18.8644 9.75803 18.0893 9.75194 16.9958C9.74964 16.5816 9.41199 16.2477 8.99778 16.25C8.58357 16.2523 8.24966 16.59 8.25196 17.0042C8.25799 18.0857 8.28387 18.9871 8.41916 19.7236C8.55839 20.4816 8.82363 21.1267 9.34857 21.6517C9.95048 22.2536 10.7084 22.5125 11.6085 22.6335C12.4754 22.75 13.5778 22.75 14.9453 22.75H16.0551C17.4227 22.75 18.525 22.75 19.392 22.6335C20.2921 22.5125 21.0499 22.2536 21.6519 21.6517C22.2538 21.0497 22.5127 20.2919 22.6337 19.3918C22.7503 18.5248 22.7502 17.4225 22.7502 16.0549V7.94513C22.7502 6.57754 22.7503 5.47522 22.6337 4.60825C22.5127 3.70814 22.2538 2.95027 21.6519 2.34835C21.0499 1.74643 20.2921 1.48754 19.392 1.36652C18.525 1.24996 17.4227 1.24998 16.0551 1.25H14.9453Z"
        fill="#e5e7eb" />
        <path
        d="M2.00098 11.249C1.58676 11.249 1.25098 11.5848 1.25098 11.999C1.25098 12.4132 1.58676 12.749 2.00098 12.749L13.9735 12.749L12.0129 14.4296C11.6984 14.6991 11.662 15.1726 11.9315 15.4871C12.2011 15.8016 12.6746 15.838 12.9891 15.5685L16.4891 12.5685C16.6553 12.426 16.751 12.218 16.751 11.999C16.751 11.7801 16.6553 11.5721 16.4891 11.4296L12.9891 8.42958C12.6746 8.16002 12.2011 8.19644 11.9315 8.51093C11.662 8.82543 11.6984 9.2989 12.0129 9.56847L13.9735 11.249L2.00098 11.249Z"
        fill="#e5e7eb" />
      </svg>
      </button></a>
  @else
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit" class="button-logout">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
        d="M8.25 5.25L9 4.5H18L18.75 5.25V18.75L18 19.5H9L8.25 18.75V16.5H9.75V18H17.25V6H9.75V7.5H8.25V5.25Z"
        fill="#e5e7eb" />
        <path fill-rule="evenodd" clip-rule="evenodd"
        d="M7.06068 12.7499L14.25 12.7499L14.25 11.2499L7.06068 11.2499L8.78035 9.53027L7.71969 8.46961L4.18936 11.9999L7.71969 15.5303L8.78035 14.4696L7.06068 12.7499Z"
        fill="#e5e7eb" />
      </svg>

      </button>
    </form>
  @endguest
  </div>

  <div class="layout">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
      <div class="sidebar-header">
        <div class="logo-container">
          <div class="logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="9" />
              <line x1="9" y1="9" x2="9" y2="15" />
              <line x1="15" y1="9" x2="15" y2="15" />
              <line x1="12" y1="9" x2="12" y2="15" />
            </svg>
          </div>
          <span class="logo-text">LioMart</span>
        </div>
      </div>

      <nav class="sidebar-nav">
        @if (Auth::user() && Auth::user()->role === 'admin')
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
          style="text-decoration: none; color: #363467;">

          <div class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="7" height="9"></rect>
              <rect x="14" y="3" width="7" height="5"></rect>
              <rect x="14" y="12" width="7" height="9"></rect>
              <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            <span style="font-size: 14px">Dashboard</span>
          </div>
        </a>
        @endif
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}"
          style="text-decoration: none; color: #363467;">

          <div class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <span style="font-size: 14px">Menu</span>
          </div>
        </a>
        @if (Auth::user() && Auth::user()->role === 'admin')
        <a href="{{ route('products.report') }}" class="{{ request()->routeIs('products.report') ? 'active' : '' }}"
          style="text-decoration: none; color: #363467;">
          <div class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 3h18v18H3z" stroke="currentColor" fill="none" />
              <line x1="3" y1="9" x2="21" y2="9" />
              <line x1="9" y1="21" x2="9" y2="9" />
            </svg>
            <span style="font-size: 14px">Laporan Produk</span>
          </div>
        </a>
        @endif

        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}"
          style="text-decoration: none; color: #363467;">
          <div class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span style="font-size: 14px">Transaction History</span>
          </div>
        </a>
        @if (Auth::user() && Auth::user()->role === 'admin')
      <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}"
        style="text-decoration: none; color: #363467;">
        <div class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
          <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
          <path d="M7 21v-2a4 4 0 0 1 3-3.87" />
          <circle cx="12" cy="7" r="4" />
        </svg>
        <span style="font-size: 14px">User Management</span>
        </div>
      </a>
    @endif


      </nav>


    </div>


    <!-- Main Content -->
    <main class="main-content position-relative border-radius-lg">


      <div>
        @yield('content')
      </div>

    </main>


    <!-- Bootstrap JS -->


    <script>
      const addProductModalButton = document.getElementById('toggle-add-product-modal');
      addProductModalButton.addEventListener('click', () => {
        new bootstrap.Modal(document.getElementById('addProductModal')).show();
      });
    </script>


    <script>
      const toggleEditBtn = document.getElementById('toggle-edit-mode');
      const items = document.querySelectorAll('.menu-item');
      let editMode = false;

      toggleEditBtn.addEventListener('click', () => {
        editMode = !editMode;
        items.forEach(item => item.classList.toggle('edit-mode', editMode));
      });

      const menuGrid = document.getElementById('menu-grid');

      menuGrid.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', (e) => {
          if (editMode) {
            e.preventDefault();
            if (!e.currentTarget.contains(e.target)) return;
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
          } else {
            // kalau editMode false, baru jalankan addToOrder
            const id = item.dataset.id;
            const name = item.querySelector('.menu-item-name').innerText.trim();
            const priceText = item.querySelector('.menu-item-price').innerText.trim();
            const price = parseInt(priceText.replace(/[^\d]/g, ''));

            addToOrder(id, name, price);
          }
        });

        item.querySelectorAll('.edit-btn, form button').forEach(btn => {
          btn.addEventListener('click', e => e.stopPropagation());
        });
      });


    </script>

    <script>
      function addRow() {
        const originalRow = document.querySelector('.product-row');
        const newRow = originalRow.cloneNode(true);

        // Reset value
        newRow.querySelector('select').selectedIndex = 0;
        newRow.querySelector('input[type="number"]').value = 1;

        // Hapus tombol ❌ lama (jika ada)
        const oldButton = newRow.querySelector('.remove-btn');
        if (oldButton) {
          oldButton.closest('.col-md-2').remove();
        }

        // Buat kolom tombol ❌
        const btnCol = document.createElement('div');
        btnCol.className = 'col-md-2 d-flex align-items-center';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-btn';
        removeBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" color="#ffffff" viewBox="0 0 24 24">
          <path d="M9 3V4H4V6H5V20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20V6H20V4H15V3H9ZM7 6H17V20H7V6Z" />
          <path d="M9 8H11V18H9V8ZM13 8H15V18H13V8Z" />
        </svg>
      `;
        removeBtn.onclick = () => removeRow(removeBtn);

        btnCol.appendChild(removeBtn);
        newRow.appendChild(btnCol);

        document.getElementById('products-wrapper').appendChild(newRow);
      }

      function removeRow(button) {
        const row = button.closest('.product-row');
        row.remove();
      }
    </script>
    <script>
      const searchInput = document.getElementById('search-input');
      const productItems = document.querySelectorAll('.menu-item');

      searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();

        productItems.forEach(item => {
          const name = item.getAttribute('data-name');
          if (name.includes(query)) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    </script>


    <!-- Optional: Responsive Fix for Sidebar -->
    <style>
      @media (max-width: 991.98px) {
        #sidenav-main {
          display: none;
        }

        main.main-content {
          margin-left: 0 !important;
        }

      }

      #fixed-footer {
        position: relative;
        bottom: 20px;
        left: 280px;
        /* lebar sidebar 250px + margin ms-4 (sekitar 30px) */
        width: calc(100% - 280px);
        z-index: 1030;
        background: transparent;
        pointer-events: none;
        /* biar tidak ganggu klik konten */
      }

      #fixed-footer .copyright {
        pointer-events: auto;
        /* tapi copyright tetap bisa diklik */
      }
    </style>

</body>

</html>