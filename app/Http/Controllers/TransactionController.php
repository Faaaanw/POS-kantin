<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user')->orderBy('transaction_time', 'asc');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('transaction_time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $transactions = $query->get();

        return view('transactions.index', compact('transactions'));
    }
    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }



    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu untuk melakukan transaksi.');
        }

        // Validasi input
        $request->validate([
            'products' => 'required|array',
            'quantities' => 'required|array',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $products = $request->input('products');
        $quantities = $request->input('quantities');

        $total = 0;

        // Hitung total harga dari semua produk
        foreach ($products as $i => $productId) {
            $product = Product::find($productId);
            if ($product) {
                $qty = $quantities[$i];
                $total += $product->price * $qty;

                // Update stok produk setelah transaksi
                if ($product->stock >= $qty) {
                    $product->decrement('stock', $qty); // Mengurangi stok produk
                } else {
                    // Jika stok tidak cukup, kembalikan pesan error
                    return redirect()->back()->with('error', 'Stok produk tidak cukup.');
                }
            }
        }

        // Hitung kembalian
        $paid = $request->paid_amount;
        $change = $paid - $total;

        // Jika uang yang dibayar kurang
        if ($change < 0) {
            return redirect()->back()->with('error', 'Jumlah bayar kurang dari total harga.');
        }

        // Simpan transaksi ke tabel transactions
        $transaction = Transaction::create([
            'user_id' => auth()->id(), // Menyimpan user_id dari user yang login
            'total_price' => $total, // Total harga
            'paid_amount' => $paid, // Jumlah uang yang dibayar
            'change' => $change, // Kembalian
            'transaction_time' => now(), // Waktu transaksi
        ]);

        // Simpan item-item yang dibeli ke tabel transaction_items
        foreach ($products as $i => $productId) {
            $product = Product::find($productId);
            if ($product) {
                $qty = $quantities[$i];
                $subtotal = $product->price * $qty;

                // Pastikan `transaction_id` terisi dengan benar
                TransactionItem::create([
                    'transaction_id' => $transaction->id, // Menyimpan id transaksi
                    'product_id' => $product->id, // Menyimpan id produk
                    'quantity' => $qty, // Jumlah produk yang dibeli
                    'price' => $product->price, // Harga produk
                    'subtotal' => $subtotal, // Harga total per produk
                ]);
            }
        }

        return redirect()->route('products.index')->with([
            'transaksi_berhasil' => true,
            'transaction_id' => $transaction->id
        ]);



    }
    public function receipt($id)
    {
        $transaction = Transaction::with('items.product', 'user')->findOrFail($id);
        return view('transactions.receipt', compact('transaction'));
    }
}
