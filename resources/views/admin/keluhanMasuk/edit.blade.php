@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Keluhan Masuk / Data Keluhan Masuk /</span> Edit Data
        </h5>

        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Data Keluhan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('complaint.update', $complaint->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="reporter">Nama Pelapor</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('reporter') is-invalid @enderror"
                                    name="reporter" value="{{ old('reporter', $complaint->reporter) }}" placeholder="Luthfi"
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
                                    name="serial_number" value="{{ old('serial_number', $complaint->serial_number) }}"
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
                                    name="location" value="{{ old('location', $complaint->location) }}"
                                    placeholder="Lokasi A" required />
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="telp">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                    name="telp" value="{{ old('telp', $complaint->telp) }}" placeholder="089475647364"
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
                                    name="institution" value="{{ old('institution', $complaint->institution) }}"
                                    placeholder="UTY" required />
                                @error('institution')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="description">Deskripsi Keluhan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                    placeholder="Hi, Jelaskan keluhan anda disini." required>{{ old('description', $complaint->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
