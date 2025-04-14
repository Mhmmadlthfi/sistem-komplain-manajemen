@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Penanganan / Data Penanganan / Detail Penanganan /</span> Riwayat Penjadwalan
            Ulang
        </h5>
        <div class="card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Riwayat penjadwalan ulang no keluhan: {{ $handling->complaint_id }}</h5>
            </div>

            <div class="table-responsive">
                <table class="table">
                    @forelse ($histories as $history)
                        <tr class="table-primary">
                            <th colspan="2">Penjadwalan ulang ke
                                {{ ($histories->currentPage() - 1) * $histories->perPage() + $loop->iteration }} :</th>
                        </tr>
                        <tr>
                            <th class="col-4">Tanggal Penjadwalan Ulang</th>
                            <td class="col-8">{{ $history->reschedule_date }}</td>
                        </tr>
                        <tr>
                            <th class="col-4">Deskripsi</th>
                            <td class="col-8">{{ $history->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </table>
            </div>
            <div class="card-footer border-top p-3">
                {!! $histories->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
@endsection
