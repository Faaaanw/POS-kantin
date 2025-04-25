@extends('app')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-main px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="#">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Buat Transaksi</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Buat Transaksi</h6>
    </nav>
  </div>
</nav>
<!-- End Navbar -->

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h5>Buat Transaksi</h5>
        </div>
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <form method="POST" action="{{ route('transactions.store') }}">
            @csrf

            <div id="products-wrapper">
              <div class="row mb-3 fw-bold">
                <div class="col-md-6">Produk</div>
                <div class="col-md-4">Qty</div>
                <div class="col-md-2">Aksi</div>
              </div>

              <!-- Row Produk Pertama -->
              <div class="row mb-3 product-row">
                <div class="col-md-6">
                  <select name="products[]" class="form-control" required>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price, 0) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="number" name="quantities[]" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                  <!-- Kosong agar align dengan row tambahan yang nanti ada tombol hapus -->
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-sm btn-primary mb-3" onclick="addRow()">+ Tambah Produk</button>

            <div class="mb-3">
              <label for="paid_amount">Jumlah Bayar</label>
              <input type="number" name="paid_amount" class="form-control" required min="0">
            </div>

            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function addRow() {
    const wrapper = document.getElementById('products-wrapper');
    const originalRow = wrapper.querySelector('.product-row');
    const newRow = originalRow.cloneNode(true);

    // Reset nilai di row baru
    newRow.querySelector('select').selectedIndex = 0;
    newRow.querySelector('input[type="number"]').value = 1;

    // Hapus tombol ❌ jika ada
    const oldBtnCol = newRow.querySelector('.col-md-2');
    if (oldBtnCol) oldBtnCol.remove();

    // Tambah tombol ❌
    const btnCol = document.createElement('div');
    btnCol.className = 'col-md-2 d-flex align-items-center';

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-danger btn-sm';
    removeBtn.innerText = '❌';
    removeBtn.onclick = () => removeRow(removeBtn);

    btnCol.appendChild(removeBtn);
    newRow.appendChild(btnCol);

    wrapper.appendChild(newRow);
  }

  function removeRow(button) {
    const row = button.closest('.product-row');
    row.remove();
  }
</script>
@endsection
