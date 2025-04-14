@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Kelola User /</span> Data User
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

        <!-- Tabel Data User -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="my-0">Data User</h5>
                <a href="{{ route('manage-users.create') }}" class="btn btn-primary ms-2"><i class='bx bx-plus'></i>
                    Tambah
                    Data</a>
            </div>

            <div class="card-body border-bottom p-2">
                <form action="{{ route('manage-users.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari data..." name="search"
                            value="{{ request('search') }}" />
                        <select class="form-select" name="role" id="role">
                            <option selected value="" {{ request('role') == '' ? 'selected' : '' }}>
                                Tampilkan semua</option>
                            <option value="aftersales" {{ request('role') == 'aftersales' ? 'selected' : '' }}>Aftersales
                            </option>
                            <option value="manager_marketing"
                                {{ request('role') == 'manager_marketing' ? 'selected' : '' }}>Manager Marketing</option>
                            <option value="marketing" {{ request('role') == 'marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="teknisi" {{ request('role') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
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
                            <th>No Petugas</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $status = [
                                '1' => 'bg-label-primary',
                                '0' => 'bg-label-dark',
                            ];
                        @endphp
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                <td>{{ $user->no_staff }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->telp }}</td>
                                <td>{{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::replace('_', ' ', $user->role)) }}
                                </td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $user->status ? 'bg-label-success' : 'bg-label-dark' }}">
                                        {{ $user->status ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $user->id }}">
                                        <i class='tf-icons bx bx-file-find'></i></a>
                                    <a href="{{ route('manage-users.edit', $user->id) }}"
                                        class="btn btn-sm btn-icon btn-outline-warning"><i
                                            class='tf-icons bx bx-edit'></i></a>
                                    <form action="{{ route('manage-users.destroy', $user->id) }}" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-icon btn-outline-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                                class='tf-icons bx bx-trash'></i></button>
                                    </form>
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
                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
        <!--/ Tabel Data User -->
    </div>

    @include('admin.users.modal.detail')
@endsection
