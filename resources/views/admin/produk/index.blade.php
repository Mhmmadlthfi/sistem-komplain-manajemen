@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Master /</span> Data Product
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

        <!-- Tabel Produk -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="my-0">Data Product</h5>
                @can('marketing')
                    <a href="{{ route('products.create') }}" class="btn btn-primary ms-2"><i class='bx bx-plus'></i>
                        Tambah
                        Data</a>
                @endcan
            </div>

            <div class="card-body border-bottom p-2">
                <form action="{{ route('products.index') }}">
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
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            @can('marketing')
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->name }}</td>
                                @can('marketing')
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-sm btn-icon btn-outline-warning"><i
                                                class='tf-icons bx bx-edit'></i></a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-sm btn-icon btn-outline-danger"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                @if (!$product->can_delete) disabled @endif>
                                                <i class='tf-icons bx bx-trash'></i></button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer border-top p-3">
                {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel Produk -->
    </div>
@endsection
