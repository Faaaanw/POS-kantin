@extends('app') <!-- Layout umummu -->

@section('content')
  <div class="p-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Penjualan Hari Ini -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
      <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
      💰
      </div>
      <div>
      <p class="text-sm text-gray-500" style="color: black;">Total Penjualan Hari Ini</p>
      <p class="text-lg font-semibold" style="color: black;">Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</p>
      </div>
    </div>

    <!-- Jumlah Transaksi Hari Ini -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
      <div class="p-3 bg-blue-100 text-blue-600 rounded-full mr-4">
      🧾
      </div>
      <div>
      <p class="text-sm text-gray-500" style="color: black;">Jumlah Transaksi</p>
      <p class="text-lg font-semibold" style="color: black;">{{ $transactionCountToday }}</p>
      </div>
    </div>

    <!-- Produk Terjual Hari Ini -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
      <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full mr-4">
      📦
      </div>
      <div>
      <p class="text-sm text-gray-500" style="color: black;">Produk Terjual</p>
      <p class="text-lg font-semibold" style="color: black;">{{ $productsSoldToday }}</p>
      </div>
    </div>

    <!-- Produk Hampir Habis -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center">
      <div class="p-3 bg-red-100 text-red-600 rounded-full mr-4">
      ⚠️
      </div>
      <div>
      <p class="text-sm text-gray-500" style="color: black;">Stok Hampir Habis</p>
      <p class="text-lg font-semibold" style="color: black;">{{ $lowStockProducts }}</p>
      </div>
    </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold" style="color: black;">Transaksi Terbaru</h2>
      <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:underline">Lihat Semua</a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
      <thead>
        <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
        <th class="py-3 px-4" style="color: black;">ID</th>
        <th class="py-3 px-4" style="color: black;">Waktu</th>
        <th class="py-3 px-4" style="color: black;">Total Harga</th>
        <th class="py-3 px-4" style="color: black;">Dibayar</th>
        <th class="py-3 px-4" style="color: black;">Kembalian</th>
        <th class="py-3 px-4" style="color: black;">Kasir</th>
        </tr>
      </thead>
      <tbody>
        @foreach($latestTransactions as $transaction)
      <tr class="border-t">
      <td class="py-3 px-4" style="color: black;">{{ $transaction->id }}</td>
      <td class="py-3 px-4" style="color: black;">{{ $transaction->transaction_time->format('d-m-Y H:i') }}</td>
      <td class="py-3 px-4" style="color: black;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
      <td class="py-3 px-4" style="color: black;">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
      <td class="py-3 px-4" style="color: black;">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
      <td class="py-3 px-4" style="color: black;">{{ $transaction->user->name }}</td>
      </tr>
    @endforeach
      </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection