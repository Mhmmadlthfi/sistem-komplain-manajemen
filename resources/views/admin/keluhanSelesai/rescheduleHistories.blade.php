@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Keluhan Selesai / Data Keluhan Selesai / Detail Keluhan Selesai /</span>
            Riwayat Penjadwalan
            Ulang
        </h5>
        <div class="card">
            <div class="card-header d-flex justify-content-beetween align-items-center border-bottom p-3">
                <h5 class="my-0">Riwayat penjadwalan ulang no keluhan: {{ $resolved_complaint->handling->complaint_id }}
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table">
                    @foreach ($histories as $history)
                        <tr class="table-primary">
                            <th colspan="2" class="text-center">Penjadwalan ulang ke {{ $loop->iteration }}</th>
                        </tr>
                        <tr>
                            <th class="col-4">Tanggal Penjadwalan Ulang</th>
                            <td class="col-8">{{ $history->reschedule_date }}</td>
                        </tr>
                        <tr>
                            <th class="col-4">Deskripsi</th>
                            <td class="col-8">{{ $history->description }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
