<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'PLN Sleman', 'telp' => '81374846758', 'email' => 'plnsleman@gmail.com'],
            ['name' => 'PLN Jogja Kota', 'telp' => '89365872353', 'email' => 'plnjogjakota@gmail.com'],
            ['name' => 'PLN Bantul', 'telp' => '83659465837', 'email' => 'plnbantul@gmail.com'],
            ['name' => 'PLN Semarang', 'telp' => '81473975937', 'email' => 'plnsemarang@gmail.com'],
            ['name' => 'PLN Gunung Kidul', 'telp' => '87462937483', 'email' => 'plngunungkidul@gmail.com'],
            ['name' => 'PLN Magelang', 'telp' => '89555983673', 'email' => 'plnmagelang@gmail.com'],
            ['name' => 'PLN Kulon Progo', 'telp' => '89999163743', 'email' => 'plnkulonprogo@gmail.com'],
            ['name' => 'PLN Temanggung', 'telp' => '87773549872', 'email' => 'plntemanggung@gmail.com'],
            ['name' => 'PLN Wonosobo', 'telp' => '81444309837', 'email' => 'plnwonosobo@gmail.com'],
            ['name' => 'PLN Kebumen', 'telp' => '83666198374', 'email' => 'plnkebumen@gmail.com'],
        ];

        foreach ($customers as $customer) {
            DB::table('customers')->insert($customer);
        }
    }
}
