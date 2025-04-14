<?php

namespace Database\Seeders;

use App\Models\Warranty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warranties = [
            ['sale_detail_id' => 1, 'start_date' => '2023-01-02', 'end_date' => '2024-01-02'],
            ['sale_detail_id' => 2, 'start_date' => '2023-01-02', 'end_date' => '2024-01-02'],
            ['sale_detail_id' => 3, 'start_date' => '2023-01-02', 'end_date' => '2024-01-02'],
            ['sale_detail_id' => 4, 'start_date' => '2023-01-15', 'end_date' => '2024-01-15'],
            ['sale_detail_id' => 5, 'start_date' => '2023-01-15', 'end_date' => '2024-01-15'],
            ['sale_detail_id' => 6, 'start_date' => '2023-01-15', 'end_date' => '2024-01-15'],
            ['sale_detail_id' => 7, 'start_date' => '2023-02-03', 'end_date' => '2024-02-03'],
            ['sale_detail_id' => 8, 'start_date' => '2023-02-03', 'end_date' => '2024-02-03'],
            ['sale_detail_id' => 9, 'start_date' => '2023-02-03', 'end_date' => '2024-02-03'],
            ['sale_detail_id' => 10, 'start_date' => '2023-03-02', 'end_date' => '2024-03-02'],
            ['sale_detail_id' => 11, 'start_date' => '2023-03-02', 'end_date' => '2024-03-02'],
            ['sale_detail_id' => 12, 'start_date' => '2023-03-02', 'end_date' => '2024-03-02'],
            ['sale_detail_id' => 13, 'start_date' => '2023-03-16', 'end_date' => '2024-03-16'],
            ['sale_detail_id' => 14, 'start_date' => '2023-03-16', 'end_date' => '2024-03-16'],
            ['sale_detail_id' => 15, 'start_date' => '2023-03-16', 'end_date' => '2024-03-16'],
            ['sale_detail_id' => 16, 'start_date' => '2023-04-03', 'end_date' => '2024-04-03'],
            ['sale_detail_id' => 17, 'start_date' => '2023-04-03', 'end_date' => '2024-04-03'],
            ['sale_detail_id' => 18, 'start_date' => '2023-04-03', 'end_date' => '2024-04-03'],
            ['sale_detail_id' => 19, 'start_date' => '2023-04-17', 'end_date' => '2024-04-17'],
            ['sale_detail_id' => 20, 'start_date' => '2023-04-17', 'end_date' => '2024-04-17'],
            ['sale_detail_id' => 21, 'start_date' => '2023-04-17', 'end_date' => '2024-04-17'],
            ['sale_detail_id' => 22, 'start_date' => '2023-05-04', 'end_date' => '2024-05-04'],
            ['sale_detail_id' => 23, 'start_date' => '2023-05-04', 'end_date' => '2024-05-04'],
            ['sale_detail_id' => 24, 'start_date' => '2023-05-04', 'end_date' => '2024-05-04'],
            ['sale_detail_id' => 25, 'start_date' => '2023-05-18', 'end_date' => '2024-05-18'],
            ['sale_detail_id' => 26, 'start_date' => '2023-05-18', 'end_date' => '2024-05-18'],
            ['sale_detail_id' => 27, 'start_date' => '2023-05-18', 'end_date' => '2024-05-18'],
            ['sale_detail_id' => 28, 'start_date' => '2023-06-05', 'end_date' => '2024-06-05'],
            ['sale_detail_id' => 29, 'start_date' => '2023-06-05', 'end_date' => '2024-06-05'],
            ['sale_detail_id' => 30, 'start_date' => '2023-06-05', 'end_date' => '2024-06-05'],
            ['sale_detail_id' => 31, 'start_date' => '2023-06-17', 'end_date' => '2024-06-17'],
            ['sale_detail_id' => 32, 'start_date' => '2023-06-17', 'end_date' => '2024-06-17'],
            ['sale_detail_id' => 33, 'start_date' => '2023-06-17', 'end_date' => '2024-06-17'],
            ['sale_detail_id' => 34, 'start_date' => '2023-07-02', 'end_date' => '2024-07-02'],
            ['sale_detail_id' => 35, 'start_date' => '2023-07-02', 'end_date' => '2024-07-02'],
            ['sale_detail_id' => 36, 'start_date' => '2023-07-02', 'end_date' => '2024-07-02'],
            ['sale_detail_id' => 37, 'start_date' => '2023-07-16', 'end_date' => '2024-07-16'],
            ['sale_detail_id' => 38, 'start_date' => '2023-07-16', 'end_date' => '2024-07-16'],
            ['sale_detail_id' => 39, 'start_date' => '2023-07-16', 'end_date' => '2024-07-16'],
            ['sale_detail_id' => 40, 'start_date' => '2023-08-01', 'end_date' => '2024-08-01'],
            ['sale_detail_id' => 41, 'start_date' => '2023-08-01', 'end_date' => '2024-08-01'],
            ['sale_detail_id' => 42, 'start_date' => '2023-08-01', 'end_date' => '2024-08-01'],
            ['sale_detail_id' => 43, 'start_date' => '2023-08-18', 'end_date' => '2024-08-18'],
            ['sale_detail_id' => 44, 'start_date' => '2023-08-18', 'end_date' => '2024-08-18'],
            ['sale_detail_id' => 45, 'start_date' => '2023-08-18', 'end_date' => '2024-08-18'],
            ['sale_detail_id' => 46, 'start_date' => '2023-09-05', 'end_date' => '2024-09-05'],
            ['sale_detail_id' => 47, 'start_date' => '2023-09-05', 'end_date' => '2024-09-05'],
            ['sale_detail_id' => 48, 'start_date' => '2023-09-05', 'end_date' => '2024-09-05'],
            ['sale_detail_id' => 49, 'start_date' => '2023-09-18', 'end_date' => '2024-09-18'],
            ['sale_detail_id' => 50, 'start_date' => '2023-09-18', 'end_date' => '2024-09-18'],
        ];

        foreach ($warranties as $warranty) {
            Warranty::create($warranty);
        }
    }
}
