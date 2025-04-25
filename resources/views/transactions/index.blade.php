@extends('app')

@section('content')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">Transaction</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Transaction</h6>
        </nav>
    </div>
</nav>
<div class="container-transaction">
    <h2 class="mb-4 text-center">Daftar Transaksi</h2>
    <div class="table-wrapper-scroll">
        <table class="table-trancsaction">
            <thead class="table-dark">
                <tr>
                    <th >ID</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Kembali</th>
                    <th>Waktu</th>
                     
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $tx)
                    <tr>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">{{ $tx->id }}</td>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">{{ $tx->user->name ?? 'Tidak Diketahui' }}</td>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">Rp {{ number_format($tx->change, 0, ',', '.') }}</td>
                        <td class="text-uppercase text-secondary text-l font-weight-bolder opacity-9 ">{{ \Carbon\Carbon::parse($tx->transaction_time)->format('d-m-Y H:i') }}</td>
                         
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
            max-height: 400px; /* Atur sesuai kebutuhan */
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



        th, td {
            padding: 15px;
            text-align: center;
        }

        thead {
            background-color: #343a40;
            color: white;
        }
    </style>
</div>

@endsection
