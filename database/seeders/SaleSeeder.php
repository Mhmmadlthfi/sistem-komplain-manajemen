<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            ['customer_id' => 1, 'sent_date' => '2023-01-01', 'received_date' => '2023-01-02', 'user_id' => 4, 'spk' => 'SPK001'],
            ['customer_id' => 2, 'sent_date' => '2023-01-15', 'received_date' => '2023-01-16', 'user_id' => 5, 'spk' => 'SPK002'],
            ['customer_id' => 3, 'sent_date' => '2023-02-01', 'received_date' => '2023-02-02', 'user_id' => 4, 'spk' => 'SPK003'],
            ['customer_id' => 4, 'sent_date' => '2023-03-01', 'received_date' => '2023-03-02', 'user_id' => 5, 'spk' => 'SPK004'],
            ['customer_id' => 5, 'sent_date' => '2023-03-15', 'received_date' => '2023-03-16', 'user_id' => 4, 'spk' => 'SPK005'],
            ['customer_id' => 6, 'sent_date' => '2023-04-01', 'received_date' => '2023-04-02', 'user_id' => 5, 'spk' => 'SPK006'],
            ['customer_id' => 7, 'sent_date' => '2023-04-15', 'received_date' => '2023-04-16', 'user_id' => 4, 'spk' => 'SPK007'],
            ['customer_id' => 8, 'sent_date' => '2023-05-01', 'received_date' => '2023-05-02', 'user_id' => 5, 'spk' => 'SPK008'],
            ['customer_id' => 9, 'sent_date' => '2023-05-15', 'received_date' => '2023-05-16', 'user_id' => 4, 'spk' => 'SPK009'],
            ['customer_id' => 10, 'sent_date' => '2023-06-01', 'received_date' => '2023-06-02', 'user_id' => 5, 'spk' => 'SPK010'],
            ['customer_id' => 1, 'sent_date' => '2022-06-15', 'received_date' => '2023-06-16', 'user_id' => 4, 'spk' => 'SPK011'],
            ['customer_id' => 2, 'sent_date' => '2023-07-01', 'received_date' => '2023-07-02', 'user_id' => 5, 'spk' => 'SPK012'],
            ['customer_id' => 3, 'sent_date' => '2023-07-15', 'received_date' => '2023-07-16', 'user_id' => 4, 'spk' => 'SPK013'],
            ['customer_id' => 4, 'sent_date' => '2023-08-01', 'received_date' => '2023-08-02', 'user_id' => 5, 'spk' => 'SPK014'],
            ['customer_id' => 5, 'sent_date' => '2023-08-15', 'received_date' => '2023-08-16', 'user_id' => 4, 'spk' => 'SPK015'],
            ['customer_id' => 6, 'sent_date' => '2023-09-01', 'received_date' => '2023-09-02', 'user_id' => 5, 'spk' => 'SPK016'],
            ['customer_id' => 7, 'sent_date' => '2023-09-15', 'received_date' => '2023-09-16', 'user_id' => 4, 'spk' => 'SPK017'],
            ['customer_id' => 8, 'sent_date' => '2023-10-01', 'received_date' => '2023-10-02', 'user_id' => 5, 'spk' => 'SPK018'],
            ['customer_id' => 9, 'sent_date' => '2023-10-15', 'received_date' => '2023-10-16', 'user_id' => 4, 'spk' => 'SPK019'],
            ['customer_id' => 10, 'sent_date' => '2023-11-01', 'received_date' => '2023-11-02', 'user_id' => 5, 'spk' => 'SPK020']
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
}
