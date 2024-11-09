@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penanganan /</span> Daftar Penanganan
        </h5>

        @if (session('success'))
            @php
                $message = session('success.message');
                $message = str_replace(
                    '@complaintId',
                    '<b>' . htmlspecialchars(session('success.complaintId'), ENT_QUOTES, 'UTF-8') . '</b>',
                    $message,
                );
                $message = str_replace(
                    '@status',
                    '<b><u>' . htmlspecialchars(session('success.status'), ENT_QUOTES, 'UTF-8') . '</u></b>',
                    $message,
                );
            @endphp
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! $message !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
            $statusClass = [
                'Dalam Penanganan' => 'bg-label-primary',
                'Sudah diperbaiki' => 'bg-label-success',
                'Penjadwalan ulang' => 'bg-label-warning',
                'Tidak dapat diperbaiki' => 'badge bg-label-dark',
            ];
        @endphp

        @foreach ($handlings as $handling)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-4 border-right-md border-bottom-md">
                            <div>
                                <p class="card-text" style="margin-bottom: 0;">Customer :</p>
                                <h5 class="card-title" style="margin-top: 10px;">{{ $handling->sale->customer->name }}</h5>
                            </div>
                            <div>
                                <p class="card-text" style="margin-bottom: 0;">Teknisi :</p>
                                <h5 class="card-title set-mb" style="margin-top: 10px;">{{ $handling->user->name }}</h5>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-9 set-mt ">
                                    <div class="row mb-3">
                                        <div class="col-6">No Keluhan</div>
                                        <div class="col-6 text-right"><strong>{{ $handling->complaint_id }}</strong></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">Lokasi</div>
                                        <div class="col-6 text-right"><strong>
                                                @php
                                                    $location = '';
                                                    foreach ($handling->sale->saleDetail as $saleDetail) {
                                                        if (
                                                            $saleDetail->serial_number ===
                                                            $handling->complaint->serial_number
                                                        ) {
                                                            $location = $saleDetail->location;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                {{ $location }}
                                            </strong></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">Tanggal Penanganan</div>
                                        <div class="col-6 text-right"><strong>{{ $handling->handling_date }}</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">Status Penanganan</div>
                                        <div class="col-6 text-right">
                                            <span
                                                class="badge {{ $statusClass[$handling->status] ?? 'bg-label-primary' }} me-0">
                                                <strong>{{ $handling->status }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if ($handling->status === 'Dalam penanganan' || $handling->status === 'Penjadwalan ulang')
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-end flex-column set-mt-btn">
                                            <a href="{{ route('technician-handling.show', $handling->id) }}"
                                                class="btn btn-primary mt-auto">Proses</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-end flex-column set-mt-btn">
                                            <span class="badge bg-success">Selesai</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
