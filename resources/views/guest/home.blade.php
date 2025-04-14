@extends('guest.layouts.main')

@section('left-content')
    <img src="{{ asset('/assets/img/logo/logo_arhadi.png') }}" alt="Logo" class="company-logo">
    <div class="company-info">
        <h1>Sistem Manajemen Komplain Customer</h1>
        <h2>PT. Arhadi Fajar Perkasa</h2>
    </div>
    <div class="check-link">
        <p>Sudah mengajukan Keluhan? <a href="{{ route('guest.checkDataView') }}">Cek disini.</a></p>
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
            <h5 class="mb-0">Formulir Keluhan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="reporter">Nama Pelapor</label>
                    <input type="text" class="form-control @error('reporter') is-invalid @enderror" id="reporter"
                        name="reporter" value="{{ old('reporter') }}" placeholder="Luthfi" required />
                    @error('reporter')
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
                <div class="mb-3">
                    <label class="form-label" for="location">Lokasi</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                        name="location" value="{{ old('location') }}" placeholder="Lokasi X" required />
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="telp">No Telepon</label>
                    <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp"
                        name="telp" value="{{ old('telp') }}" placeholder="081XXXXXXXXX" required />
                    @error('telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="institution">Nama Institusi</label>
                    <input type="text" class="form-control @error('institution') is-invalid @enderror" id="institution"
                        name="institution" value="{{ old('institution') }}" placeholder="PLN X" required />
                    @error('institution')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Deskripsi Keluhan</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        placeholder="Hi, Jelaskan keluhan anda disini." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="attachment">Lampiran</label>
                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment"
                        name="attachment" />
                    @error('attachment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if (!$errors->has('attachment'))
                        <div id="defaultFormControlHelp" class="form-text">
                            Boleh dikosongkan jika tidak ada. jika lampiran hanya satu, silahkan upload file
                            dengan format JPG, JPEG, atau PNG.
                            Jika
                            lampiran lebih dari satu, silahkan convert ke PDF terlebih dahulu, kemudian upload
                            file PDF tersebut. Ukuran Maks file adalah 3MB.
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection
