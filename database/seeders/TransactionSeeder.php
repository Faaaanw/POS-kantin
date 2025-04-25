<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Tambahkan transaksi dan ambil ID-nya
        $transactionId = DB::table('transactions')->insertGetId([
            'user_id' => 1,
            'total_price' => 50000,
            'paid_amount' => 100000,
            'change' => 50000,
            'transaction_time' => Carbon::now(),
        ]);

        // Tambahkan item transaksinya
        DB::table('transaction_items')->insert([
            'transaction_id' => $transactionId,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 25000,
            'subtotal' => 50000,
        ]);
    }
}
