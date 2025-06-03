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
                    </div>
                    <div class="menu-title-container" style="text-decoration: none;">
                        <h1 class="menu-title" style="text-decoration: none;">Laporan Produk</h1>
                    </div>
                </div>
                <div class="container-monthly ">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Laporan Produk</h2>

                    <form method="GET" action="{{ route('products.report') }}"
                        class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                                Filter
                            </button>
                            <button style="background-color:#d62222; margin-left: 10px;" class="w-full text-white font-semibold py-2 rounded hover:bg-blue-700 transition">
                                <a href="{{ route('products.report') }}" class="btn-reset-products" style="color:white; text-decoration: none;">Reset</a>

                            </button>
                             
                        </div>
                    </form>

                    @if($products->count())
                        <div class="overflow-x-auto">
                            <div class="scrollable-table-report">
                                <table class="min-w-full bg-white border border-gray-200 rounded text-sm">
                                    <thead class="bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="py-2 px-4 text-left border-b">Nama</th>
                                            <th class="py-2 px-4 text-left border-b">Kategori</th>
                                            <th class="py-2 px-4 text-left border-b">Harga</th>
                                            <th class="py-2 px-4 text-left border-b">Stok</th>
                                            <th class="py-2 px-4 text-left border-b">Tanggal Ditambahkan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                                                <td class="py-2 px-4 border-b">{{ $product->category->name ?? '-' }}</td>
                                                <td class="py-2 px-4 border-b">{{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td class="py-2 px-4 border-b">{{ $product->stock }}</td>
                                                <td class="py-2 px-4 border-b">{{ $product->created_at->format('d-m-Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 mt-4">Tidak ada produk pada rentang tanggal tersebut.</p>
                    @endif
                </div>
                <style>
                     .scrollable-table-monthly {
                                max-height: 200px;
                                overflow-y: auto;
                                border: 1px solid #dee2e6;
                                border-radius: 10px;
                                scrollbar-width: none;
                            }

                            /* Biar scrollbar halus (opsional) */
                            .scrollable-table-monthly::-webkit-scrollbar {
                                display: none;
                            }

                            .scrollable-table-monthly::-webkit-scrollbar-thumb {
                                background-color: #aaa;
                                border-radius: 3px;
                            }
                </style>

            </div>
        </main>
    </div>
@endsection