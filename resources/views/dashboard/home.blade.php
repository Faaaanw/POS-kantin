@extends('app') <!-- Layout umummu -->

@section('content')
  <div class="layout">

    <div class="home-main">

    <div class="home-container">
      <div class="breadcrumb" style="text-decoration: none;">
      <div class="header-home">
        <div class="header-wrapper">
        <span>Pages</span>
        <span class="separator">/</span>
        <span style="color: white">Home</span>
        </div>
        <div class="menu-title-container" style="text-decoration: none;">
        <h1 class="menu-title" style="text-decoration: none;">Home</h1>
        </div>

      </div>


      </div>
      <div class="home-content-scroll">

      <div class="home-content">

        <div class="pos-container">

        <!-- Total Penjualan Hari Ini -->
        <div class="bg-white shadow rounded-lg p-4 flex items-center items-dashboard">
          <div class="text-icon">
          💰
          </div>
          <div>
          <p class="text-sm text-gray-500">Total Penjualan Hari Ini</p>
          <p class="text-lg font-semibold">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</p>
          </div>
        </div>

        <!-- Jumlah Transaksi Hari Ini -->
        <div class="bg-white shadow rounded-lg p-4 flex items-center items-dashboard">
          <div class="text-icon-2">
          🧾
          </div>
          <div>
          <p class="text-sm text-gray-500">Jumlah Transaksi</p>
          <p class="text-lg font-semibold">{{ $transactionCountToday }}</p>
          </div>
        </div>

        <!-- Produk Terjual Hari Ini -->
        <div class="bg-white shadow rounded-lg p-4 flex items-center items-dashboard">
          <div class="text-icon-3">
          📦
          </div>
          <div>
          <p class="text-sm text-gray-500">Produk Terjual</p>
          <p class="text-lg font-semibold">{{ $productsSoldToday }}</p>
          </div>
        </div>

        <!-- Produk Hampir Habis -->
        <div class="bg-white shadow rounded-lg p-4 flex items-center items-dashboard">
          <div class="text-icon-4">
          ⚠️
          </div>
          <div>
          <p class="text-sm text-gray-500">Stok Hampir Habis</p>
          <p class="text-lg font-semibold">{{ $lowStockProducts }}</p>
          </div>
        </div>
        </div>

        <div class="transaction-home mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Transaksi Terbaru</h2>
        <div class="overflow-x-auto rounded-lg">
          <table class="w-full text-left border-collapse bg-white">
          <thead class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
            <tr>
            <th class="py-3 px-6">#</th>
            <th class="py-3 px-6">Waktu</th>
            <th class="py-3 px-6">Total Harga</th>
            <th class="py-3 px-6">Dibayar</th>
            <th class="py-3 px-6">Kembalian</th>
            <th class="py-3 px-6">Kasir</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 text-sm font-light">
            @foreach($latestTransactions as $transaction)
        <tr class="border-b hover:bg-gray-50 transition duration-200 ease-in-out">
        <td class="py-3 px-6">{{ $loop->iteration }}</td>
        <td class="py-3 px-6">{{ $transaction->transaction_time->format('d-m-Y H:i') }}</td>
        <td class="py-3 px-6">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        <td class="py-3 px-6">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
        <td class="py-3 px-6">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
        <td class="py-3 px-6">{{ $transaction->user->name }}</td>
        </tr>
      @endforeach
          </tbody>
          </table>
        </div>
        </div>


      </div>
      </div>


      <!-- Transaksi Terbaru -->

    </div>
    </div>


    <!-- Summary Cards -->
  </div>

@endsection