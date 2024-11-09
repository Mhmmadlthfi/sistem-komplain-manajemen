<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $complaints = [
            [
                "reporter" => "Adi Putra",
                "serial_number" => "SN001",
                "location" => "Kecamatan Mlati",
                "description" => "Produk LBS Three Way mengalami gangguan pada konektor listrik utama",
                "telp" => "081234567890",
                "institution" => "PLN Sleman",
                "date" => "2024-05-10",
            ],
            [
                "reporter" => "Budi Santoso",
                "serial_number" => "SN004",
                "location" => "Kecamatan Kota Gede",
                "description" => "Produk LBS Three Way tidak dapat menyala setelah penggunaan beberapa kali",
                "telp" => "082345678901",
                "institution" => "PLN Jogja Kota",
                "date" => "2024-05-20",
            ],
            [
                "reporter" => "Cahyo Prasetyo",
                "serial_number" => "SN007",
                "location" => "Kecamatan Bantul",
                "description" => "Produk LBS Three Way mengalami kerusakan setelah penggunaan jangka panjang",
                "telp" => "083456789012",
                "institution" => "PLN Bantul",
                "date" => "2024-05-30",
            ],
            [
                "reporter" => "Darmawan",
                "serial_number" => "SN010",
                "location" => "Kecamatan Banyumanik",
                "description" => "Masalah pada kabel produk LBS Three Way mengakibatkan koneksi listrik terputus",
                "telp" => "084567890123",
                "institution" => "PLN Semarang",
                "date" => "2024-06-03",
            ],
            [
                "reporter" => "Eko Susanto",
                "serial_number" => "SN013",
                "location" => "Kecamatan Gedangsari",
                "description" => "Produk LBS Three Way tidak sesuai dengan spesifikasi listrik yang diinginkan",
                "telp" => "085678901234",
                "institution" => "PLN Gunung Kidul",
                "date" => "2024-06-06",
            ],
            [
                "reporter" => "Fajar Nugroho",
                "serial_number" => "SN016",
                "location" => "Kecamatan Borobudur",
                "description" => "Penggunaan produk LBS Three Way tidak optimal, membutuhkan perbaikan",
                "telp" => "086789012345",
                "institution" => "PLN Magelang",
                "date" => "2024-06-10",
            ],
            [
                "reporter" => "Gilang Saputra",
                "serial_number" => "SN019",
                "location" => "Kecamatan Wates",
                "description" => "Produk LBS Three Way mengalami kerusakan fisik akibat kecelakaan",
                "telp" => "087890123456",
                "institution" => "PLN Kulon Progo",
                "date" => "2024-06-13",
            ],
            [
                "reporter" => "Hendra Wijaya",
                "serial_number" => "SN022",
                "location" => "Kecamatan Kledung",
                "description" => "Produk LBS Three Way tidak terdeteksi oleh sistem listrik",
                "telp" => "088901234567",
                "institution" => "PLN Temanggung",
                "date" => "2024-06-15",
            ],
            [
                "reporter" => "Indra Kusuma",
                "serial_number" => "SN025",
                "location" => "Kecamatan Kalibawang",
                "description" => "Produk LBS Three Way membutuhkan perbaikan setelah pemakaian intensif",
                "telp" => "089012345678",
                "institution" => "PLN Wonosobo",
                "date" => "2024-06-20",
            ],
            [
                "reporter" => "Joko Wibowo",
                "serial_number" => "SN028",
                "location" => "Kecamatan Adimulyo",
                "description" => "Produk LBS Three Way mengeluarkan suara aneh saat digunakan",
                "telp" => "085123456789",
                "institution" => "PLN Kebumen",
                "date" => "2024-06-23",
            ],
            [
                "reporter" => "Budi Santoso",
                "serial_number" => "SN031",
                "location" => "Kecamatan Gamping",
                "description" => "Cubicle SDD mengalami masalah pada pengendalian arus listrik. Perangkat ini dirancang untuk menghubungkan dan membagi tenaga listrik, namun saat ini tidak dapat mengendalikan beban dengan baik.",
                "telp" => "085678912345",
                "institution" => "PLN Sleman",
                "date" => "2024-06-25",
            ],
            [
                "reporter" => "Kurniawan",
                "serial_number" => "SN033",
                "location" => "Kecamatan Ngampilan",
                "description" => "Cubicle SDD tidak dapat melakukan booting dengan benar. Perangkat ini seharusnya menghubungkan dan melindungi sirkuit tenaga listrik, tetapi saat ini tidak berfungsi sesuai harapan.",
                "telp" => "085678912346",
                "institution" => "PLN Jogja Kota",
                "date" => "2024-07-02",
            ],
            [
                "reporter" => "Lukman Hakim",
                "serial_number" => "SN035",
                "location" => "Kecamatan Bantul",
                "description" => "Cubicle SDD menunjukkan penurunan performa dalam distribusi tenaga listrik. Perangkat ini seharusnya membagi tenaga listrik dengan efisien, tetapi saat ini mengalami masalah.",
                "telp" => "085678912347",
                "institution" => "PLN Bantul",
                "date" => "2024-07-10",
            ],
            [
                "reporter" => "Mahendra",
                "serial_number" => "SN037",
                "location" => "Kecamatan Candisari",
                "description" => "Cubicle SDD mengalami penurunan fungsi pada proteksi sirkuit. Perangkat ini dirancang untuk melindungi sistem dari gangguan listrik, tetapi saat ini tidak berfungsi dengan baik.",
                "telp" => "085678912348",
                "institution" => "PLN Semarang",
                "date" => "2024-07-18",
            ],
            [
                "reporter" => "Nugroho Pratama",
                "serial_number" => "SN039",
                "location" => "Kecamatan Ngawen",
                "description" => "Cubicle SDD mengalami kesulitan dalam mengatur distribusi tenaga listrik. Perangkat ini seharusnya memastikan pembagian tenaga yang merata, namun saat ini menunjukkan gangguan.",
                "telp" => "085678912349",
                "institution" => "PLN Gunung Kidul",
                "date" => "2024-07-25",
            ],
        ];

        foreach ($complaints as $complaint) {
            Complaint::create($complaint);
        }
    }
}
