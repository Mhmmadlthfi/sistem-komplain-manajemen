@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Master / Data Customer /</span> Tambah Data
        </h5>

        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Customer</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nama Customer</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="PLN X" value="{{ old('name') }}"
                                    autocomplete="name" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="telp">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" id="telp"
                                    class="form-control phone-mask @error('telp') is-invalid @enderror"
                                    placeholder="089384757384" name="telp" value="{{ old('telp') }}" required />
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="plnx@gmail.com"
                                    value="{{ old('email') }}" autocomplete="email" required />
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div class="form-text">Inputkan alamat email yang valid.</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10 mt-1">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
