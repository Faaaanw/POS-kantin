<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan item transaksi contoh
        DB::table('transaction_items')->insert([
            'transaction_id' => 1,  // Transaksi yang ditambahkan
            'product_id' => 1,  // Misalnya produk dengan id 1
            'quantity' => 2,  // Jumlah produk yang dibeli
            'price' => 25000,  // Harga per produk
            'subtotal' => 50000,  // Subtotal (quantity * price)
        ]);
    }
}
