<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $totalSalesToday = Transaction::whereDate('transaction_time', today())->sum('total_price');

        $transactionCountToday = Transaction::whereDate('transaction_time', today())->count();

        $productsSoldToday = \DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereDate('transactions.transaction_time', today())
            ->sum('transaction_items.quantity');

        $lowStockProducts = Product::where('stock', '<', 5)->count();

        $latestTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard.home', compact(
            'totalSalesToday',
            'transactionCountToday',
            'productsSoldToday',
            'lowStockProducts',
            'latestTransactions'
        ));
    }
}
