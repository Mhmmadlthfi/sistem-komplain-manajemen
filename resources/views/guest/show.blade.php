@extends('guest.layouts.main')

@section('left-content')
    <img src="{{ asset('/assets/img/logo/logo_arhadi.png') }}" alt="Logo" class="company-logo">
    <div class="company-info">
        <h1>Sistem Manajemen Komplain Customer</h1>
        <h2>PT. Arhadi Fajar Perkasa</h2>
    </div>
    <div class="check-link">
        <p><a href="{{ route('guest.index') }}">Halaman Utama</a></p>
    </div>
@endsection

@section('right-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-3">
        <h5 class="card-header p-3 border-bottom">Data Keluhan Anda :</h5>
        <div class="table-responsive">
            <table class="table table-borderless">
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
                    <th class="col-6">No Keluhan</th>
                    <td class="col-6">{{ $complaint->id }}</td>
                </tr>
                <tr>
                    <th class="col-6">Pelapor</th>
                    <td class="col-6">{{ $complaint->reporter }}</td>
                </tr>
                <tr>
                    <th class="col-6">No Seri Produk</th>
                    <td class="col-6">{{ $complaint->serial_number }}</td>
                </tr>
                <tr>
                    <th class="col-6">Lokasi</th>
                    <td class="col-6">{{ $complaint->location }}</td>
                </tr>
                <tr>
                    <th class="col-6">No Telepon</th>
                    <td class="col-6">{{ $complaint->telp }}</td>
                </tr>
                <tr>
                    <th class="col-6">Instansi</th>
                    <td class="col-6">{{ $complaint->institution }}</td>
                </tr>
                <tr>
                    <th class="col-6">Tanggal Input Data</th>
                    <td class="col-6">{{ $complaint->date }}</td>
                </tr>
                <tr>
                    <th class="col-6">Status Keluhan</th>
                    <td class="col-6">
                        <span class="badge {{ $statusClass[$complaint->status] ?? 'bg-label-primary' }} me-0">
                            {{ $complaint->status }}
                        </span>
                    </td>
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
        <div class="card-footer p-3">
            <h5>Deskripsi Keluhan :</h5>
            <p>{{ $complaint->description }}</p>
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('guest.download-pdf', encrypt($complaint->id)) }}" class="btn btn-primary"><i
                        class='bx bxs-download'></i> Download</a>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <h5 class="card-header p-3 border-bottom">Petugas yang dapat dihubungi :</h5>
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <th class="col-6">Nama Petugas</th>
                    <td class="col-6">Ervan</td>
                </tr>
                <tr>
                    <th class="col-6">No Telepon</th>
                    <td class="col-6">0894756473857</td>
                </tr>
                <tr>
                    <th class="col-6">Divisi</th>
                    <td class="col-6">Aftersales</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
