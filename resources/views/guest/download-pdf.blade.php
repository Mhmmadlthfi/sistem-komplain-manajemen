<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keluhan Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            /* Garis di bawah kop surat */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header .logo {
            width: 30%;
            /* Lebar tetap untuk kolom logo */
        }

        .header .logo img {
            width: 100%;
            height: auto;
        }

        .header .text {
            padding-left: 30px;
            /* Jarak antara logo dan teks */
        }

        .header .text h1 {
            margin: 0;
            font-size: 24px;
            text-align: left;
        }

        .header .text p {
            margin: 5px 0;
            font-size: 14px;
            text-align: left;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            width: 30%;
        }

        td.separator {
            width: 6%;
        }

        td.value {
            width: 64%;
        }

        .description {
            margin-bottom: 40px;
        }

        small {
            margin-top: 30px;
            font-size: x-small;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td class="logo">
                        <img src="{{ public_path('assets/img/logo/logo_arhadi.png') }}" alt="Logo Perusahaan">
                    </td>
                    <td class="text">
                        <h1>PT. ARHADI FAJAR PERKASA</h1>
                        <p>Jl. Majapahit No.297, Kalicari, Kec. Pedurungan, Kota Semarang, Jawa Tengah 50246</p>
                        <p>Telepon : (024) 76412046 (Kantor) | 08112673151 (WhatsApp)</p>
                        <p>Email : enquiry@arhadigroup.com</p>
                        <p>Website : www.arhadigroup.com</p>
                    </td>
                </tr>
            </table>
        </div>
        <h2>Data Keluhan Anda</h2>
        <table>
            <tr>
                <th class="label">No Keluhan</th>
                <td class="separator">:</td>
                <td class="value">{{ $id }}</td>
            </tr>
            <tr>
                <th class="label">Pelapor</th>
                <td class="separator">:</td>
                <td class="value">{{ $reporter }}</td>
            </tr>
            <tr>
                <th class="label">No Seri Produk</th>
                <td class="separator">:</td>
                <td class="value">{{ $serial_number }}</td>
            </tr>
            <tr>
                <th class="label">Lokasi</th>
                <td class="separator">:</td>
                <td class="value">{{ $location }}</td>
            </tr>
            <tr>
                <th class="label">No Telepon</th>
                <td class="separator">:</td>
                <td class="value">{{ $telp }}</td>
            </tr>
            <tr>
                <th class="label">Instansi</th>
                <td class="separator">:</td>
                <td class="value">{{ $institution }}</td>
            </tr>
            <tr>
                <th class="label">Tanggal Input Data</th>
                <td class="separator">:</td>
                <td class="value">{{ $date }}</td>
            </tr>
            <tr>
                <th class="label">Status Keluhan</th>
                <td class="separator">:</td>
                <td class="value">{{ $status }}</td>
            </tr>
        </table>
        <div class="description">
            <h3>Deskripsi Keluhan :</h3>
            <p>{{ $description }}</p>
        </div>
        <small>*Silahkan tunjukan bukti pengajuan ini jika diperlukan, atau jika ditanyakan oleh petugas kami.</small>
    </div>
</body>

</html>
