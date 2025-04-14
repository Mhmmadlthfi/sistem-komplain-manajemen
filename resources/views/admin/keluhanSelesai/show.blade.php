@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Keluhan / Daftar Data Keluhan /</span> Detail Data Keluhan
        </h5>

        {{-- Data Keluhan Selesai --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Detail Data Keluhan</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    @php
                        $statusClass = [
                            'Selesai' => 'bg-label-success',
                            'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                        ];
                    @endphp
                    <tr>
                        <th class="col-4">No Keluhan</th>
                        <td class="col-8">{{ $resolved_complaint->handling->complaint_id }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Pelapor</th>
                        <td class="col-8">{{ $resolved_complaint->handling->complaint->reporter }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">No Telepon Pelapor</th>
                        <td class="col-8">{{ $resolved_complaint->handling->complaint->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Customer</th>
                        <td class="col-8">{{ $resolved_complaint->handling->sale->customer->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Surat Perjanjian Kerjasama (SPK)</th>
                        <td class="col-8">{{ $resolved_complaint->handling->sale->spk }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">No Telepon Customer</th>
                        <td class="col-8">{{ $resolved_complaint->handling->sale->customer->telp }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Lokasi</th>
                        <td class="col-8">
                            @php
                                $location = '';
                                foreach ($resolved_complaint->handling->sale->saleDetail as $saleDetail) {
                                    if (
                                        $saleDetail->serial_number ===
                                        $resolved_complaint->handling->complaint->serial_number
                                    ) {
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
                        <td class="col-6">{{ $resolved_complaint->handling->complaint->date }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Penanganan</th>
                        <td class="col-6">{{ $resolved_complaint->handling->handling_date }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Penjadwalan Ulang</th>
                        <td class="col-6">
                            {{ $resolved_complaint->handling->reschedule_date ? $resolved_complaint->handling->reschedule_date : '-' }}
                            @if ($resolved_complaint->handling->reschedule_date)
                                <a href="{{ route('resolved-complaint.reschedule-histories', $resolved_complaint->id) }}"
                                    class="ms-3 btn btn-xs rounded-pill btn-outline-info">Riwayat</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-6">Teknisi</th>
                        <td class="col-6">{{ $resolved_complaint->handling->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="col-6">Status Penyelesaian</th>
                        <td class="col-6">
                            <span
                                class="badge rounded-pill {{ $statusClass[$resolved_complaint->status] ?? 'bg-label-success' }} me-0">
                                {{ $resolved_complaint->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-6">Tanggal Penyelesaian</th>
                        <td class="col-6">{{ $resolved_complaint->created_at->format('Y-m-d') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- / Data Keluhan Selesai --}}

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
                            @if ($resolved_complaint->handling->initial_condition)
                                {{ $resolved_complaint->handling->initial_condition }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Tindakan</th>
                        <td class="col-8">
                            @if ($resolved_complaint->handling->action)
                                {{ $resolved_complaint->handling->action }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Hasil Perbaikan</th>
                        <td class="col-8">
                            @if ($resolved_complaint->handling->repair_result)
                                {{ $resolved_complaint->handling->repair_result }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Catatan Perbaikan</th>
                        <td class="col-8">
                            @if ($resolved_complaint->handling->repair_notes)
                                {{ $resolved_complaint->handling->repair_notes }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Bukti Perbaikan</th>
                        <td class="col-8">
                            @if ($resolved_complaint->handling->repair_evidence)
                                <a href="/storage/{{ $resolved_complaint->handling->repair_evidence }}"
                                    class="btn btn-xs rounded-pill btn-outline-info">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="col-4">Lokasi Penanganan</th>
                        <td class="col-8">
                            @if ($resolved_complaint->handling->handling_location)
                                {{ $resolved_complaint->handling->handling_location }}
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
