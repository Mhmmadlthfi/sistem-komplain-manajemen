@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penjualan / Data Penjualan /</span> Detail Data Penjualan
        </h5>

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

    </div>
@endsection
