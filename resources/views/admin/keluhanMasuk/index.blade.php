@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Keluhan Masuk /</span> Data Keluhan Masuk
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

        <!-- Tabel keluhan masuk -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="my-0">Data Keluhan Masuk</h5>
                <button class="btn btn-success ms-auto" data-bs-toggle="modal" data-bs-target="#exportModal"><i
                        class='bx bx-export mb-1'></i> Export</button>
                @can('aftersales')
                    <a href="{{ route('complaint.create') }}" class="btn btn-primary ms-2"><i class='bx bx-plus'></i>
                        Tambah
                        Data</a>
                @endcan
            </div>

            <div class="card-body border-bottom p-2">
                <form action="{{ route('complaint.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data..." name="search"
                            value="{{ request('search') }}" />
                        <select class="form-select" name="status" id="status">
                            <option value="">Tampilkan semua</option>
                            @foreach ($statusOptions as $optStatus)
                                <option value="{{ $optStatus }}"
                                    {{ request('status') === $optStatus ? 'selected' : '' }}>
                                    {{ $optStatus }}
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
                            <th>Pelapor</th>
                            <th>No Telepon</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            @can('aftersales')
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $statusClass = [
                                'Diterima' => 'bg-label-primary',
                                'Diproses' => 'bg-label-info',
                                'Selesai' => 'bg-label-success',
                                'Tidak dapat diperbaiki' => 'badge bg-label-dark',
                                'Tidak Valid' => 'badge bg-label-danger',
                            ];
                        @endphp
                        @forelse ($complaints as $complaint)
                            <tr>
                                <td>{{ ($complaints->currentPage() - 1) * $complaints->perPage() + $loop->iteration }}</td>
                                <td>{{ $complaint->id }}</td>
                                <td>{{ $complaint->reporter }}</td>
                                <td>{{ $complaint->telp }}</td>
                                <td>{{ $complaint->date }}</td>
                                <td>
                                    <span class="badge {{ $statusClass[$complaint->status] ?? 'bg-label-primary' }} me-0">
                                        {{ $complaint->status }}
                                    </span>
                                </td>
                                @can('aftersales')
                                    <td>
                                        <a href="{{ route('complaint.show', $complaint->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-info">
                                            <i class='tf-icons bx bx-file-find'></i></a>
                                        <a href="{{ route('complaint.edit', $complaint->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-warning"><i
                                                class='tf-icons bx bx-edit'></i></a>
                                        <form action="{{ route('complaint.destroy', $complaint->id) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                @if (!$complaint->can_delete) disabled @endif>
                                                <i class='tf-icons bx bx-trash'></i></button>
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
                {!! $complaints->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel keluhan masuk -->

        {{-- @include('admin.keluhanMasuk.modal.detail') --}}
        @include('admin.keluhanMasuk.modal.export')

    </div>
@endsection
