@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Keluhan /</span> Daftar Data Keluhan
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

        <!-- Tabel Keluhan Selesai -->
        <div class="card">
            <div class="card-header p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="my-0">Data Keluhan</h5>
                <button class="btn btn-success ms-auto" data-bs-toggle="modal" data-bs-target="#exportModal"><i
                        class='bx bx-export mb-1'></i> Export</button>
            </div>

            <div class="card-body border-bottom p-2">
                <form action="{{ route('resolved-complaint.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data..." name="search"
                            value="{{ request('search') }}" />
                        <select class="form-select" name="status" id="status">
                            <option selected value="">Tampilkan semua</option>
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', request('status')) === $status ? 'selected' : '' }}>
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
                            <th>Tanggal Penyelesaian</th>
                            <th>Status</th>
                            @can('aftersales')
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $statusClass = [
                                'Selesai' => 'bg-label-success',
                                'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                            ];
                        @endphp
                        @forelse ($resolvedComplaints as $resolvedComplaint)
                            <tr>
                                <td>{{ ($resolvedComplaints->currentPage() - 1) * $resolvedComplaints->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $resolvedComplaint->handling->complaint_id }}</td>
                                <td>{{ $resolvedComplaint->handling->sale->customer->name }}</td>
                                <td>
                                    @php
                                        $location = '';
                                        foreach ($resolvedComplaint->handling->sale->saleDetail as $saleDetail) {
                                            if (
                                                $saleDetail->serial_number ===
                                                $resolvedComplaint->handling->complaint->serial_number
                                            ) {
                                                $location = $saleDetail->location;
                                                break;
                                            }
                                        }
                                    @endphp
                                    {{ $location }}
                                </td>
                                <td>{{ $resolvedComplaint->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $statusClass[$resolvedComplaint->status] ?? 'bg-label-success' }} me-0">
                                        {{ $resolvedComplaint->status }}
                                    </span>
                                </td>
                                @can('aftersales')
                                    <td>
                                        <a href="{{ route('resolved-complaint.show', $resolvedComplaint->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-info">
                                            <i class='tf-icons bx bx-file-find'></i></a>
                                        <form action="{{ route('resolved-complaint.destroy', $resolvedComplaint->id) }}"
                                            method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini? Perlu diingat ketika menghapus data ini, maka data Penanganan dan data Keluhan terkait juga akan terhapus.')"><i
                                                    class='tf-icons bx bx-trash'></i></button>
                                        </form>
                                    </td>
                                @endcan
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
                {!! $resolvedComplaints->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel Keluhan Selesai -->
    </div>

    @include('admin.keluhanSelesai.modal.export')
@endsection
