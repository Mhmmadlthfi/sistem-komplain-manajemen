@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Halaman Dashboard
        </h5>
        <!-- Accordion -->
        <h5 class="mt-4">Halo, Selamat Datang Kembali {{ auth()->user()->name }}!</h5>
        <!--/ Accordion -->
    </div>
@endsection
