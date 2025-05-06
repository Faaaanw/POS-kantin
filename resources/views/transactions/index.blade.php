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
                </div>

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
                        <a href="{{ route('transactions.index') }}"
                            class="btn-reset">Reset</a>
                    </form>

                    <div class=" p-4 flex items-center items-dashboard">
                        <table class="table-trancsaction">
                            <thead>
                                <tr>
                                    <th style="background-color:white; color: gray;">#</th>
                                    <th style="background-color:white; color: gray;">Kasir</th>
                                    <th style="background-color:white; color: gray;">Total</th>
                                    <th style="background-color:white; color: gray;">Dibayar</th>
                                    <th style="background-color:white; color: gray;">Kembali</th>
                                    <th style="background-color:white; color: gray;">Waktu</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $tx)
                                    <tr>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">
                                            {{ $loop->iteration }}</td>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">
                                            {{ $tx->user->name ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp
                                            {{ number_format($tx->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp
                                            {{ number_format($tx->paid_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp
                                            {{ number_format($tx->change, 0, ',', '.') }}
                                        </td>
                                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">
                                            {{ \Carbon\Carbon::parse($tx->transaction_time)->format('d-m-Y H:i') }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <style>
                        .table-wrapper-scroll {
                            max-height: 400px;
                            /* Atur sesuai kebutuhan */
                            overflow-y: auto;
                            width: 100%;
                            border: 1px solid #dee2e6;
                            border-radius: 10px;
                            scrollbar-width: thin;
                            scrollbar-color: #ffffff transparent;
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
                </div>
            </div>
        </main>
    </div>

@endsection