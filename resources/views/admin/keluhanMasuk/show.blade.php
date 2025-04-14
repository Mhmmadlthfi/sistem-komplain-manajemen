@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Keluhan Masuk / Data Keluhan Masuk /</span> Validasi Data
        </h5>

        {{-- Data keluhan yang dipilih --}}
        <div class="card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Data Keluhan Masuk</h5>
                @if ($complaint->status === 'Selesai')
                    <span class="badge rounded-pill bg-success ms-auto">Keluhan selesai ditangani</span>
                @elseif($complaint->status === 'Diproses')
                    <span class="badge rounded-pill bg-info ms-auto">Keluhan sedang dalam proses penanganan</span>
                @elseif($complaint->status === 'Tidak Valid')
                    <span class="badge rounded-pill bg-label-danger ms-auto">Keluhan ini telah ditandai sebagai tidak
                        valid</span>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    @php
                        $statusClass = [
                            'Diterima' => 'bg-label-primary',
                            'Diproses' => 'bg-label-info',
                            'Selesai' => 'bg-label-success',
                            'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                            'Tidak Valid' => 'badge bg-label-danger',
                        ];
                    @endphp
                    <tr>
                        <th class="col-5">No Keluhan</th>
                        <td class="col-7">{{ $complaint->id }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Pelapor</th>
                        <td class="col-7">{{ $complaint->reporter }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">No Telepon</th>
                        <td class="col-7">{{ $complaint->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">No Seri Produk</th>
                        <td class="col-7">{{ $complaint->serial_number }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Lokasi</th>
                        <td class="col-7">{{ $complaint->location }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Tanggal</th>
                        <td class="col-7">{{ $complaint->date }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Instansi</th>
                        <td class="col-7">{{ $complaint->institution }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Status</th>
                        <td class="col-7">
                            <span class="badge {{ $statusClass[$complaint->status] ?? 'bg-label-primary' }} me-0">
                                {{ $complaint->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-5">Deskripsi Keluhan</th>
                        <td class="col-7">{{ $complaint->description }}</td>
                    </tr>
                    <tr>
                        <th class="col-5">Lampiran</th>
                        <td class="col-7">
                            @if ($complaint->attachment)
                                <a href="/storage/{{ $complaint->attachment }}"
                                    class="btn btn-xs rounded-pill btn-outline-info">Lihat</a>
                            @else
                                -
                            @endif

                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer text-end p-3">
                @if ($complaint->status === 'Diterima')
                    @php
                        $isSaleEmpty = !$sale;
                    @endphp

                    <button class="btn btn-primary ms-2" @if ($isSaleEmpty) disabled @endif
                        @if (!$isSaleEmpty) data-bs-toggle="modal" data-bs-target="#handlingModal" @endif>
                        Proses
                    </button>

                    <form action="{{ route('complaint.invalid-data', $complaint->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger ms-2"
                            onclick="return confirm('Apakah Anda yakin ingin menandai keluhan ini sebagai Tidak Valid?')">
                            Tidak Valid
                        </button>
                    </form>
                @else
                    <button class="btn btn-primary ms-2" disabled>Proses</button>
                    <button class="btn btn-danger ms-2" disabled>Tidak Valid</button>
                @endif
            </div>
        </div>
        {{-- / Data keluhan yang dipilih --}}

        @if ($sale)
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
                            <td class="col-6">{{ $sale->customer->name }}</td>
                        </tr>
                        <tr>
                            <th class="col-6">Surat Perjanjian Kerjasama (SPK)</th>
                            <td class="col-6">{{ $sale->spk }}</td>
                        </tr>
                        <tr>
                            <th class="col-6">No Telepon</th>
                            <td class="col-6">{{ $sale->customer->telp }}</td>
                        </tr>
                        <tr>
                            <th class="col-6">Email</th>
                            <td class="col-6">{{ $sale->customer->email }}</td>
                        </tr>
                        <tr>
                            <th class="col-6">Tanggal Kirim</th>
                            <td class="col-6">{{ $sale->sent_date }}</td>
                        </tr>
                        <tr>
                            <th class="col-6">Tanggal Diterima</th>
                            <td class="col-6">{{ $sale->received_date }}</td>
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
                            @foreach ($sale->saleDetail as $saleDetail)
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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                    <h5 class="my-0">Data Garansi</h5>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Seri Produk</th>
                                <th>Nama Produk</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status Garansi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($sale->saleDetail as $saleDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $saleDetail->serial_number }}</td>
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
        @else
            <div class="card-body p-2">
                <div class="divider">
                    <div class="divider-text">Ups! Data pembelian customer tidak ditemukan.</div>
                </div>
            </div>
        @endif
    </div>

    @include('admin.keluhanMasuk.modal.handling')
@endsection
