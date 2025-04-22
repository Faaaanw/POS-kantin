<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan produk contoh
        DB::table('products')->insert([
            ['name' => 'Es Teh', 'price' => 5000, 'stock' => 100, 'category_id' => 1],
            ['name' => 'Nasi Goreng', 'price' => 15000, 'stock' => 50, 'category_id' => 2],
            ['name' => 'Keripik', 'price' => 7000, 'stock' => 200, 'category_id' => 3],
        ]);
    }
}
