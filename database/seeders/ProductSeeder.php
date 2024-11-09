<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['product_code' => 'PRD01', 'name' => 'LBS Three Way'],
            ['product_code' => 'PRD02', 'name' => 'Cubicle SDD'],
            ['product_code' => 'PRD03', 'name' => 'Control Box'],
            ['product_code' => 'PRD04', 'name' => 'Relay'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}
