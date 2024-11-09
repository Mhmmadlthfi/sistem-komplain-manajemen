@extends('guest.layouts.main')

@section('left-content')
    <img src="{{ asset('/assets/img/logo/logo_arhadi.png') }}" alt="Logo" class="company-logo">
    <div class="company-info">
        <h1>Sistem Manajemen Komplain Customer</h1>
        <h2>PT. Arhadi Fajar Perkasa</h2>
    </div>
    <div class="check-link">
        <p>Belum mengajukan Keluhan? <a href="{{ route('guest.index') }}">Ajukan disini.</a></p>
    </div>
@endsection

@section('right-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cek Data Keluhan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guest.checkDataPost') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="id">No Keluhan</label>
                    <input type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                        id="id" value="{{ old('id') }}" placeholder="1" required />
                    @error('id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="serial_number">No Seri Produk</label>
                    <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                        id="serial_number" name="serial_number" value="{{ old('serial_number') }}" placeholder="LBS001"
                        required />
                    @error('serial_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection
