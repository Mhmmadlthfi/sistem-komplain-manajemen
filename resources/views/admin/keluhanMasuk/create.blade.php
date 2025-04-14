@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Keluhan Masuk / Data Keluhan Masuk /</span> Tambah Data
        </h5>

        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Keluhan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="reporter">Nama Pelapor</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('reporter') is-invalid @enderror"
                                    name="reporter" id="reporter" value="{{ old('reporter') }}" placeholder="Luthfi"
                                    required />
                                @error('reporter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="serial_number">No Seri Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                    name="serial_number" id="serial_number" value="{{ old('serial_number') }}"
                                    placeholder="LBS001" required />
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="location">Lokasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" id="location" value="{{ old('location') }}" placeholder="Lokasi X"
                                    required />
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="telp">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                    name="telp" id="telp" value="{{ old('telp') }}" placeholder="081XXXXXXXXX"
                                    required />
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="institution">Nama Instansi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                    name="institution" id="institution" value="{{ old('institution') }}" placeholder="UTY"
                                    required />
                                @error('institution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="description">Deskripsi Keluhan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                    placeholder="Hi, Jelaskan keluhan anda disini." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="attachment" class="col-sm-2 col-form-label">Lampiran</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('attachment') is-invalid @enderror" type="file"
                                    name="attachment" id="attachment" />
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
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
