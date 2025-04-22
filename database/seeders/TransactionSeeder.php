<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan transaksi contoh
        DB::table('transactions')->insert([
            'user_id' => 1,  // Misalnya admin melakukan transaksi
            'total_price' => 50000,
            'paid_amount' => 100000,
            'change' => 50000,
            'transaction_time' => Carbon::now(),
        ]);
    }
}
