@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penanganan / Daftar Penanganan / </span> Proses Penanganan
        </h5>

        {{-- Data Keluhan --}}
        <div class="card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Data Keluhan</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th class="col-5">No Keluhan</th>
                        <td class="col-7">{{ $handling->complaint->id }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Pelapor</th>
                        <td class="col-7">{{ $handling->complaint->reporter }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">No Telepon</th>
                        <td class="col-7">{{ $handling->complaint->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">No Seri Produk</th>
                        <td class="col-7">{{ $handling->complaint->serial_number }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Lokasi</th>
                        <td class="col-7">{{ $handling->complaint->location }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Tanggal</th>
                        <td class="col-7">{{ $handling->complaint->date }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Instansi</th>
                        <td class="col-7">{{ $handling->complaint->institution }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Deskripsi Keluhan</th>
                        <td class="col-7">{{ $handling->complaint->description }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Lampiran</th>
                        <td class="col-7">
                            @if ($handling->complaint->attachment)
                                <a href="/storage/{{ $handling->complaint->attachment }}"
                                    class="btn btn-xs rounded-pill btn-outline-info">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- / Data Keluhan --}}

        <div class="card-body p-2">
            <div class="divider">
                <div class="divider-text">Data Pembelian Customer</div>
            </div>
        </div>

        {{-- Data Penjualan --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Data Penjualan</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <tr>
                        <th class="col-6">Customer</th>
                        <td class="col-6">{{ $handling->sale->customer->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Surat Perjanjian Kerjasama (SPK)</th>
                        <td class="col-6">{{ $handling->sale->spk }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">No Telepon</th>
                        <td class="col-6">{{ $handling->sale->customer->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Email</th>
                        <td class="col-6">{{ $handling->sale->customer->email }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Kirim</th>
                        <td class="col-6">{{ $handling->sale->sent_date }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Diterima</th>
                        <td class="col-6">{{ $handling->sale->received_date }}</td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- / Data Penjualan --}}

        {{-- Data Produk --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-beetween align-items-center p-3 border-bottom">
                <h5 class="my-0">Data Produk</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Seri Produk</th>
                            <th>Nama Produk</th>
                            <th>Lokasi</th>
                            <th>Tanggal Komisioning</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($handling->sale->saleDetail as $saleDetail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $saleDetail->serial_number }}</td>
                                <td>{{ $saleDetail->product->name }}</td>
                                <td>{{ $saleDetail->location }}</td>
                                <td>{{ $saleDetail->commissioning_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- / Data Produk --}}

        {{-- Data Garansi --}}
        <div class="card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Data Garansi</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status Garansi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($handling->sale->saleDetail as $saleDetail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $saleDetail->product->name }}</td>
                                <td>{{ $saleDetail->warranty->start_date }}</td>
                                <td>{{ $saleDetail->warranty->end_date }}</td>
                                <td>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $start_date = \Carbon\Carbon::parse($saleDetail->warranty->start_date);
                                        $end_date = \Carbon\Carbon::parse($saleDetail->warranty->end_date);
                                    @endphp

                                    @if ($now->lt($start_date))
                                        <span class="badge rounded-pill bg-warning">Belum Dimulai</span>
                                    @elseif ($now->between($start_date, $end_date))
                                        <span class="badge rounded-pill bg-success">Aktif</span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- / Data Garansi --}}

        <div class="card-body p-2">
            <div class="divider">
                <div class="divider-text">Silahkan input hasil Penanganan dibawah ini</div>
            </div>
        </div>

        {{-- Hasil Penanganan --}}
        <div class="card mb-4" id="form-card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Hasil Penanganan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('technician-handling.update', $handling->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="my-3">
                        <label for="initial_condition" class="form-label">Kondisi Awal</label>
                        <textarea id="initial_condition" class="form-control @error('initial_condition') is-invalid @enderror"
                            name="initial_condition" rows="3">{{ old('initial_condition') }}</textarea>
                        @error('initial_condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="action" class="form-label">Tindakan</label>
                        <textarea id="action" class="form-control @error('action') is-invalid @enderror" name="action" rows="3">{{ old('action') }}</textarea>
                        @error('action')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="repair_result" class="form-label">Hasil Perbaikan</label>
                        <textarea id="repair_result" class="form-control @error('repair_result') is-invalid @enderror" name="repair_result"
                            rows="3">{{ old('repair_result') }}</textarea>
                        @error('repair_result')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="repair_notes" class="form-label">Catatan Perbaikan</label>
                        <textarea id="repair_notes" class="form-control @error('repair_notes') is-invalid @enderror" name="repair_notes"
                            rows="3">{{ old('repair_notes') }}</textarea>
                        @error('repair_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 mt-2">
                        <label for="repair_evidence" class="form-label">Bukti Perbaikan</label>
                        <input id="repair_evidence" class="form-control @error('repair_evidence') is-invalid @enderror"
                            type="file" name="repair_evidence" />
                        @error('repair_evidence')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (!$errors->has('repair_evidence'))
                            <div id="defaultFormControlHelp" class="form-text">
                                Jika bukti perbaikan hanya satu, silahkan upload file dengan format JPG, JPEG, atau PNG.
                                Jika bukti perbaikan lebih dari satu, silahkan convert ke PDF terlebih dahulu, kemudian
                                upload
                                file PDF tersebut. Ukuran Maks file adalah 3MB.
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="handling_location" class="form-label">Lokasi Penanganan</label>
                        <input id="handling_location"
                            class="form-control @error('handling_location') is-invalid @enderror" type="text"
                            name="handling_location" readonly>
                        @error('handling_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (!$errors->has('handling_location'))
                            <div id="defaultFormControlHelp" class="form-text">
                                Lokasi penanganan akan terisi secara otomatis jika anda telah mengizinkan lokasi di
                                pengaturan. Harap izinkan lokasi, karena data lokasi wajib ada.
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Perbaikan</label>
                        <select id="status" required class="form-select @error('status') is-invalid @enderror"
                            name="status" aria-label="Default select example">
                            <option value="" {{ old('status') === null || old('status') === '' ? 'selected' : '' }}
                                disabled>Pilih Status Perbaikan</option>
                            <option value="Sudah diperbaiki" @if (old('status') === 'Sudah diperbaiki') selected @endif>Sudah
                                diperbaiki</option>
                            <option value="Tidak dapat diperbaiki" @if (old('status') === 'Tidak dapat diperbaiki') selected @endif>Tidak
                                dapat diperbaiki</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitButton">Kirim</button>
                </form>

            </div>
        </div>
        {{-- / Hasil Penanganan --}}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // scroll otomatis ketika ada error
            var hasErrors = document.querySelectorAll('.is-invalid').length > 0;

            if (hasErrors) {
                var formCard = document.getElementById('form-card');
                formCard.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Memeriksa apakah browser mendukung Geolocation API
            if (navigator.geolocation) {
                // Meminta izin pengguna untuk mengakses lokasi
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        });

        function showPosition(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const handlingLocation = latitude + " " + longitude;

            document.getElementById("handling_location").value = handlingLocation;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert(
                        "Untuk mengirim hasil penanganan, silakan aktifkan izin lokasi di pengaturan browser Anda dan refresh halaman ini."
                    );
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Informasi lokasi tidak tersedia.");
                    break;
                case error.TIMEOUT:
                    alert("Permintaan untuk mendapatkan lokasi pengguna habis waktu.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Terjadi kesalahan yang tidak diketahui.");
                    break;
            }
        }
    </script>
@endsection
