@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Riwayat Penanganan /</span> Data Riwayat Penanganan
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

        <!-- Tabel Penanganan -->
        <div class="card">
            <div class="card-header p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="my-0">Data Riwayat Penanganan</h5>
            </div>

            <div class="card-body border-bottom p-2">
                <form action="/admin/technician-history" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data..." name="search"
                            value="{{ request('search') }}" />
                        <select class="form-select" name="status" id="status">
                            <option selected value="">Tampilkan semua</option>
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Keluhan</th>
                            <th>Customer</th>
                            <th>Lokasi</th>
                            <th>Tanggal Penanganan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $statusClass = [
                                'Sudah diperbaiki' => 'bg-label-success',
                                'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                            ];
                        @endphp
                        @forelse ($handlings as $handling)
                            <tr>
                                <td>{{ ($handlings->currentPage() - 1) * $handlings->perPage() + $loop->iteration }}</td>
                                <td>{{ $handling->complaint_id }}</td>
                                <td>{{ $handling->sale->customer->name }}</td>
                                <td>
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
                                <td>{{ $handling->handling_date }}</td>
                                <td>
                                    <span class="badge {{ $statusClass[$handling->status] ?? 'bg-label-primary' }} me-0">
                                        {{ $handling->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('technician-history.show', $handling->id) }}"
                                        class="btn btn-sm btn-icon btn-outline-info">
                                        <i class='tf-icons bx bx-file-find'></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer border-top p-3">
                {!! $handlings->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel Penanganan -->
    </div>
@endsection
