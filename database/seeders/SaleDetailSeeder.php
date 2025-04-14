<?php

namespace Database\Seeders;

use App\Models\SaleDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saleDetails = [
            // Sale ID 1 - 10 (3 products)
            ['sale_id' => 1, 'product_id' => 1, 'serial_number' => 'SN001', 'commissioning_date' => '2023-01-03', 'location' => 'Kecamatan Mlati'],
            ['sale_id' => 1, 'product_id' => 3, 'serial_number' => 'SN002', 'commissioning_date' => '2023-01-03', 'location' => 'Kecamatan Mlati'],
            ['sale_id' => 1, 'product_id' => 4, 'serial_number' => 'SN003', 'commissioning_date' => '2023-01-03', 'location' => 'Kecamatan Mlati'],
            ['sale_id' => 2, 'product_id' => 1, 'serial_number' => 'SN004', 'commissioning_date' => '2023-01-16', 'location' => 'Kecamatan Kota Gede'],
            ['sale_id' => 2, 'product_id' => 3, 'serial_number' => 'SN005', 'commissioning_date' => '2023-01-16', 'location' => 'Kecamatan Kota Gede'],
            ['sale_id' => 2, 'product_id' => 4, 'serial_number' => 'SN006', 'commissioning_date' => '2023-01-16', 'location' => 'Kecamatan Kota Gede'],
            ['sale_id' => 3, 'product_id' => 1, 'serial_number' => 'SN007', 'commissioning_date' => '2023-02-04', 'location' => 'Kecamatan Bantul'],
            ['sale_id' => 3, 'product_id' => 3, 'serial_number' => 'SN008', 'commissioning_date' => '2023-02-04', 'location' => 'Kecamatan Bantul'],
            ['sale_id' => 3, 'product_id' => 4, 'serial_number' => 'SN009', 'commissioning_date' => '2023-02-04', 'location' => 'Kecamatan Bantul'],
            ['sale_id' => 4, 'product_id' => 1, 'serial_number' => 'SN010', 'commissioning_date' => '2023-03-03', 'location' => 'Kecamatan Banyumanik'],
            ['sale_id' => 4, 'product_id' => 3, 'serial_number' => 'SN011', 'commissioning_date' => '2023-03-03', 'location' => 'Kecamatan Banyumanik'],
            ['sale_id' => 4, 'product_id' => 4, 'serial_number' => 'SN012', 'commissioning_date' => '2023-03-03', 'location' => 'Kecamatan Banyumanik'],
            ['sale_id' => 5, 'product_id' => 1, 'serial_number' => 'SN013', 'commissioning_date' => '2023-03-17', 'location' => 'Kecamatan Gedangsari'],
            ['sale_id' => 5, 'product_id' => 3, 'serial_number' => 'SN014', 'commissioning_date' => '2023-03-17', 'location' => 'Kecamatan Gedangsari'],
            ['sale_id' => 5, 'product_id' => 4, 'serial_number' => 'SN015', 'commissioning_date' => '2023-03-17', 'location' => 'Kecamatan Gedangsari'],
            ['sale_id' => 6, 'product_id' => 1, 'serial_number' => 'SN016', 'commissioning_date' => '2023-04-04', 'location' => 'Kecamatan Borobudur'],
            ['sale_id' => 6, 'product_id' => 3, 'serial_number' => 'SN017', 'commissioning_date' => '2023-04-04', 'location' => 'Kecamatan Borobudur'],
            ['sale_id' => 6, 'product_id' => 4, 'serial_number' => 'SN018', 'commissioning_date' => '2023-04-04', 'location' => 'Kecamatan Borobudur'],
            ['sale_id' => 7, 'product_id' => 1, 'serial_number' => 'SN019', 'commissioning_date' => '2023-04-18', 'location' => 'Kecamatan Wates'],
            ['sale_id' => 7, 'product_id' => 3, 'serial_number' => 'SN020', 'commissioning_date' => '2023-04-18', 'location' => 'Kecamatan Wates'],
            ['sale_id' => 7, 'product_id' => 4, 'serial_number' => 'SN021', 'commissioning_date' => '2023-04-18', 'location' => 'Kecamatan Wates'],
            ['sale_id' => 8, 'product_id' => 1, 'serial_number' => 'SN022', 'commissioning_date' => '2023-05-05', 'location' => 'Kecamatan Kledung'],
            ['sale_id' => 8, 'product_id' => 3, 'serial_number' => 'SN023', 'commissioning_date' => '2023-05-05', 'location' => 'Kecamatan Kledung'],
            ['sale_id' => 8, 'product_id' => 4, 'serial_number' => 'SN024', 'commissioning_date' => '2023-05-05', 'location' => 'Kecamatan Kledung'],
            ['sale_id' => 9, 'product_id' => 1, 'serial_number' => 'SN025', 'commissioning_date' => '2023-05-19', 'location' => 'Kecamatan Kalibawang'],
            ['sale_id' => 9, 'product_id' => 3, 'serial_number' => 'SN026', 'commissioning_date' => '2023-05-19', 'location' => 'Kecamatan Kalibawang'],
            ['sale_id' => 9, 'product_id' => 4, 'serial_number' => 'SN027', 'commissioning_date' => '2023-05-19', 'location' => 'Kecamatan Kalibawang'],
            ['sale_id' => 10, 'product_id' => 1, 'serial_number' => 'SN028', 'commissioning_date' => '2023-06-06', 'location' => 'Kecamatan Adimulyo'],
            ['sale_id' => 10, 'product_id' => 3, 'serial_number' => 'SN029', 'commissioning_date' => '2023-06-06', 'location' => 'Kecamatan Adimulyo'],
            ['sale_id' => 10, 'product_id' => 4, 'serial_number' => 'SN030', 'commissioning_date' => '2023-06-06', 'location' => 'Kecamatan Adimulyo'],

            // Sale ID 11 - 20 (2 products)
            ['sale_id' => 11, 'product_id' => 2, 'serial_number' => 'SN031', 'commissioning_date' => '2023-06-18', 'location' => 'Kecamatan Gamping'],
            ['sale_id' => 11, 'product_id' => 4, 'serial_number' => 'SN032', 'commissioning_date' => '2023-06-18', 'location' => 'Kecamatan Gamping'],
            ['sale_id' => 12, 'product_id' => 2, 'serial_number' => 'SN033', 'commissioning_date' => '2023-07-03', 'location' => 'Kecamatan Ngampilan'],
            ['sale_id' => 12, 'product_id' => 4, 'serial_number' => 'SN034', 'commissioning_date' => '2023-07-03', 'location' => 'Kecamatan Ngampilan'],
            ['sale_id' => 13, 'product_id' => 2, 'serial_number' => 'SN035', 'commissioning_date' => '2023-07-18', 'location' => 'Kecamatan Bantul'],
            ['sale_id' => 13, 'product_id' => 4, 'serial_number' => 'SN036', 'commissioning_date' => '2023-07-18', 'location' => 'Kecamatan Bantul'],
            ['sale_id' => 14, 'product_id' => 2, 'serial_number' => 'SN037', 'commissioning_date' => '2023-08-03', 'location' => 'Kecamatan Candisari'],
            ['sale_id' => 14, 'product_id' => 4, 'serial_number' => 'SN038', 'commissioning_date' => '2023-08-03', 'location' => 'Kecamatan Candisari'],
            ['sale_id' => 15, 'product_id' => 2, 'serial_number' => 'SN039', 'commissioning_date' => '2023-08-18', 'location' => 'Kecamatan Ngawen'],
            ['sale_id' => 15, 'product_id' => 4, 'serial_number' => 'SN040', 'commissioning_date' => '2023-08-18', 'location' => 'Kecamatan Ngawen'],
            ['sale_id' => 16, 'product_id' => 2, 'serial_number' => 'SN041', 'commissioning_date' => '2023-09-05', 'location' => 'Kecamatan Muntilan'],
            ['sale_id' => 16, 'product_id' => 4, 'serial_number' => 'SN042', 'commissioning_date' => '2023-09-05', 'location' => 'Kecamatan Muntilan'],
            ['sale_id' => 17, 'product_id' => 2, 'serial_number' => 'SN043', 'commissioning_date' => '2023-09-18', 'location' => 'Kecamatan Kebonharjo'],
            ['sale_id' => 17, 'product_id' => 4, 'serial_number' => 'SN044', 'commissioning_date' => '2023-09-18', 'location' => 'Kecamatan Kebonharjo'],
            ['sale_id' => 18, 'product_id' => 2, 'serial_number' => 'SN045', 'commissioning_date' => '2023-10-03', 'location' => 'Kecamatan Purwosari'],
            ['sale_id' => 18, 'product_id' => 4, 'serial_number' => 'SN046', 'commissioning_date' => '2023-10-03', 'location' => 'Kecamatan Purwosari'],
            ['sale_id' => 19, 'product_id' => 2, 'serial_number' => 'SN047', 'commissioning_date' => '2023-10-18', 'location' => 'Kecamatan Kalianget'],
            ['sale_id' => 19, 'product_id' => 4, 'serial_number' => 'SN048', 'commissioning_date' => '2023-10-18', 'location' => 'Kecamatan Kalianget'],
            ['sale_id' => 20, 'product_id' => 2, 'serial_number' => 'SN049', 'commissioning_date' => '2023-11-03', 'location' => 'Kecamatan Karangsari'],
            ['sale_id' => 20, 'product_id' => 4, 'serial_number' => 'SN050', 'commissioning_date' => '2023-11-03', 'location' => 'Kecamatan Karangsari'],
        ];

        foreach ($saleDetails as $detail) {
            SaleDetail::create($detail);
        }
    }
}
