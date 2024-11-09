@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Riwayat Penanganan / Data Riwayat Penanganan /</span> Detail Penanganan
        </h5>

        {{-- Data Penanganan --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Detail Data Penanganan</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <tr>
                        <th class="col-4">No Keluhan</th>
                        <td class="col-8">{{ $handling->complaint_id }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Pelapor</th>
                        <td class="col-8">{{ $handling->complaint->reporter }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">No Telepon Pelapor</th>
                        <td class="col-8">{{ $handling->complaint->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Customer</th>
                        <td class="col-8">{{ $handling->sale->customer->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Surat Perjanjian Kerjasama (SPK)</th>
                        <td class="col-8">{{ $handling->sale->spk }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">No Telepon Customer</th>
                        <td class="col-8">{{ $handling->sale->customer->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Lokasi</th>
                        <td class="col-8">
                            @php
                                $location = '';
                                foreach ($handling->sale->saleDetail as $saleDetail) {
                                    if ($saleDetail->serial_number === $handling->complaint->serial_number) {
                                        $location = $saleDetail->location;
                                        break;
                                    }
                                }
                            @endphp
                            {{ $location }}
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Tanggal Keluhan</th>
                        <td class="col-6">{{ $handling->complaint->date }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Penanganan</th>
                        <td class="col-6">
                            {{ $handling->handling_date }}
                        </td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Penjadwalan Ulang</th>
                        <td class="col-6">
                            {{ $handling->reschedule_date ? $handling->reschedule_date : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="col-6">Teknisi</th>
                        <td class="col-6">{{ $handling->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Status Penanganan</th>
                        <td class="col-6">
                            @php
                                $statusClass = [
                                    'Dalam penanganan' => 'bg-label-primary',
                                    'Sudah diperbaiki' => 'bg-label-success',
                                    'Penjadwalan ulang' => 'bg-label-warning',
                                    'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                                ];
                            @endphp
                            <span
                                class="badge rounded-pill {{ $statusClass[$handling->status] ?? 'bg-label-primary' }} me-0">
                                {{ $handling->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- / Data Penanganan --}}

        {{-- Hasil Penanganan --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Hasil Penanganan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th class="col-4">Kondisi Awal</th>
                        <td class="col-8">
                            @if ($handling->initial_condition)
                                {{ $handling->initial_condition }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Tindakan</th>
                        <td class="col-8">
                            @if ($handling->action)
                                {{ $handling->action }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Hasil Perbaikan</th>
                        <td class="col-8">
                            @if ($handling->repair_result)
                                {{ $handling->repair_result }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Catatan Perbaikan</th>
                        <td class="col-8">
                            @if ($handling->repair_notes)
                                {{ $handling->repair_notes }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Bukti Perbaikan</th>
                        <td class="col-8">
                            @if ($handling->repair_evidence)
                                <a href="/storage/{{ $handling->repair_evidence }}"
                                    class="btn btn-xs rounded-pill btn-outline-info">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Lokasi Penanganan</th>
                        <td class="col-8">
                            @if ($handling->handling_location)
                                {{ $handling->handling_location }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- / Hasil Penanganan --}}
    </div>
@endsection
