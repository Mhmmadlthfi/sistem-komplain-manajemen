@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penjualan /</span> Data Penjualan
        </h5>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabel Penjualan -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="my-0">Data Penjualan</h5>
                <button class="btn btn-success ms-auto" data-bs-toggle="modal" data-bs-target="#exportModal"><i
                        class='bx bx-export mb-1'></i> Export</button>
                @can('marketing')
                    <a href="{{ route('sales.create') }}" class="btn btn-primary ms-2"><i class='bx bx-plus'></i> Tambah
                        Data</a>
                @endcan
            </div>

            <div class="card-body border-bottom p-2">
                <form action="{{ route('sales.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data..." name="search"
                            value="{{ request('search') }}" />
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>SPK</th>
                            <th>Tanggal Kirim</th>
                            <th>Tanggal Diterima</th>
                            <th>PIC</th>
                            @can('marketing')
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($sales as $sale)
                            <tr>
                                <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
                                <td>{{ $sale->customer->name }}</td>
                                <td>{{ $sale->spk }}</td>
                                <td>{{ $sale->sent_date }}</td>
                                <td>{{ $sale->received_date }}</td>
                                <td>{{ $sale->user->name }}</td>
                                @can('marketing')
                                    <td>
                                        <a href="{{ route('sales.show', $sale->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-info"">
                                            <i class='tf-icons bx bx-file-find'></i></a>
                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-warning"><i
                                                class='tf-icons bx bx-edit'></i></a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                @if (!$sale->can_delete) disabled @endif>
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
                {!! $sales->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel Penjualan -->
    </div>

    @include('admin.penjualan.modal.export')
@endsection
