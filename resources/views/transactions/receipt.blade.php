<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: Arial; font-size: 14px; }
        .receipt { width: 300px; margin: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 4px; text-align: left; }
        .total { font-weight: bold; }
        .center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <h3 class="center">Kantin POS</h3>
        <p><strong>Tanggal:</strong> {{ $transaction->transaction_time }}</p>
        <p><strong>Kasir:</strong> {{ $transaction->user->name }}</p>

        <table>
            <thead>
                <tr><th>Produk</th><th>Qty</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach ($transaction->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <p class="total">Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        <p class="total">Bayar: Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
        <p class="total">Kembalian: Rp {{ number_format($transaction->change, 0, ',', '.') }}</p>
        <hr>
        <p class="center">Terima kasih!</p>
    </div>
</body>
</html>
