<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant POS System</title>
  <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/layout.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/sidebar.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/menu.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/order.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/animations.css')}} " />
  <!-- Tambahkan ini di bagian <head> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tambahkan ini sebelum </body> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body>
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
          <span class="logo-text">App Name</span>
        </div>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-item">
          <a href="{{ url('/') }}" style="text-decoration: none;">

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="7" height="9"></rect>
              <rect x="14" y="3" width="7" height="5"></rect>
              <rect x="14" y="12" width="7" height="9"></rect>
              <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            <span style="font-size: 14px">Dashboard</span>
        </div>
        <div class="nav-item">
          <a href="{{ route('products.index') }}" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <span style="font-size: 14px">Menu</span>
        </div>
        <div class="nav-item">
          <a href="{{ route('transactions.index') }}" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span style="font-size: 14px">Transaction History</span>
        </div>
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
      const toggleEditBtn = document.getElementById('toggle-edit-mode');
      const items = document.querySelectorAll('.menu-item');
      let editMode = false;

      toggleEditBtn.addEventListener('click', () => {
        editMode = !editMode;
        items.forEach(item => {
          item.classList.toggle('edit-mode', editMode);
        });
      });

      items.forEach(item => {
        item.addEventListener('click', () => {
          if (editMode) {
            const id = item.getAttribute('data-id');
            window.location.href = `/products/${id}/edit`;
          }
        });
      });
    </script>
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
        removeBtn.className = 'btn btn-danger btn-sm remove-btn';
        removeBtn.innerText = '❌';
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