@extends('app')

@section('content')
    <div class="layout">

        <main class="main-content">
            <div class="menu-container">
                <div class="transaction-header">
                    <div class="breadcrumb" style="text-decoration: none;">
                        <div class="header-wrapper">
                            <span>Pages</span>
                            <span class="separator">/</span>
                            <span style="color: white">Transaction</span>
                        </div>
                    </div>
                    <div class="menu-title-container" style="text-decoration: none;">
                        <h1 class="menu-title" style="text-decoration: none;">Transaksi</h1>
                    </div>
                </div>
                <div class="transaction-scrollable">

                    <div class="container-transaction">

                        <h2 class="mb-4 " style="color: gray;">Daftar Transaksi</h2>
                        <form method="GET" action="{{ route('transactions.index') }}" class="mb-4 flex items-center gap-2">
                            <label for="start_date">Dari:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="px-2 py-1 border rounded">

                            <label for="end_date">Sampai:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="px-2 py-1 border rounded">

                            <button type="submit" class="btn-filter">Filter</button>
                            <a href="{{ route('transactions.index') }}" class="btn-reset">Reset</a>
                        </form>

                        <div class=" p-4 flex items-center items-dashboard">
                            <div class="table-wrapper-scroll">
                                <table class="table-trancsaction">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kasir</th>
                                            <th>Total</th>
                                            <th>Dibayar</th>
                                            <th>Kembali</th>
                                            <th>Waktu</th>
                                            @if (Auth::user() && Auth::user()->role === 'kasir')
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($transactions as $tx)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tx->user->name ?? 'Tidak Diketahui' }}</td>
                                                <td>Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($tx->change, 0, ',', '.') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tx->transaction_time)->format('d-m-Y H:i') }}</td>
                                                  @if (Auth::user() && Auth::user()->role === 'kasir')
                                                <td>
                                                    <a href="{{ route('transactions.receipt', $tx->id) }}" target="_blank"
                                                        class="btn-print-receipt">Print Receipt</a>
                                                </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Belum ada transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <style>
                            .table-wrapper-scroll {
                                max-height: 200px;
                                overflow-y: auto;
                                border: 1px solid #dee2e6;
                                border-radius: 10px;
                                scrollbar-width: none;
                            }

                            /* Biar scrollbar halus (opsional) */
                            .table-wrapper-scroll::-webkit-scrollbar {
                                display: none;
                            }

                            .table-wrapper-scroll::-webkit-scrollbar-thumb {
                                background-color: #aaa;
                                border-radius: 3px;
                            }

                            .transaction-scrollable {
                                max-height: 500px;
                                /* Atur tinggi sesuai kebutuhan */
                                overflow-y: auto;
                                padding-right: 10px;
                                /* Biar konten ga ketutup */
                                scrollbar-width: none;
                            }

                            .transaction-scrollable::-webkit-scrollbar {
                                display: none;
                            }



                            thead th {
                                position: sticky;
                                top: 0;
                                background-color: #343a40;
                                z-index: 1;

                            }


                            .container-transaction {
                                margin: 20px auto;
                                padding: 30px;
                                background-color: #f8f9fa;
                                border-radius: 20px;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
                                max-width: 1000px;
                            }

                            .table-wrapper {
                                display: flex;
                                justify-content: center;
                            }

                            table.table-trancsaction {
                                width: 100%;
                                width: 900px;
                                font-size: 14px;
                                background-color: white;
                                border: 1px solid #dee2e6;
                                border-radius: 10px;
                                border-collapse: separate;
                                border-spacing: 0;
                                overflow: hidden;
                            }

                            table.table-trancsaction tbody tr {
                                border-bottom: 1px solid #dee2e6;
                            }

                            table.table-trancsaction tbody tr:hover {
                                background-color: #f1f1f1;
                                transition: background-color 0.2s ease;
                            }

                            table.table-trancsaction thead tr:first-child th:first-child {
                                border-top-left-radius: 10px;
                            }

                            table.table-trancsaction thead tr:first-child th:last-child {
                                border-top-right-radius: 10px;
                            }

                            table.table-trancsaction tbody tr:last-child td:first-child {
                                border-bottom-left-radius: 10px;
                            }

                            table.table-trancsaction tbody tr:last-child td:last-child {
                                border-bottom-right-radius: 10px;
                            }



                            th,
                            td {
                                padding: 15px;
                                text-align: center;
                            }

                            thead {
                                background-color: #343a40;
                                color: white;
                            }
                        </style>
                        <style>
                            .btn-print-receipt {
                                background-color: #007bff;
                                color: white;
                                padding: 5px 10px;
                                border-radius: 5px;
                                text-decoration: none;
                                font-size: 12px;
                            }

                            .btn-print-receipt:hover {
                                background-color: #0056b3;
                            }
                        </style>

                    </div>

                </div>
            </div>
        </main>
    </div>

@endsection