@foreach ($complaints as $complaint)
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Detail Data Keluhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="id" class="form-label">No Keluhan</label>
                            <input type="text" id="id" class="form-control" readonly
                                value="{{ $complaint->id }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="reporter" class="form-label">Pelapor</label>
                            <input type="text" id="reporter" class="form-control" readonly
                                value="{{ $complaint->reporter }}" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="serial_number" class="form-label">No Seri Produk</label>
                            <input type="text" id="serial_number" class="form-control" readonly
                                value="{{ $complaint->serial_number }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" id="location" class="form-control" readonly
                                value="{{ $complaint->location }}" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="telp" class="form-label">No Telepon</label>
                            <input type="text" id="telp" class="form-control" readonly
                                value="{{ $complaint->telp }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="institution" class="form-label">Instansi</label>
                            <input type="text" id="institution" class="form-control" readonly
                                value="{{ $complaint->institution }}" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="text" id="date" class="form-control" readonly
                                value="{{ $complaint->date }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" id="status" class="form-control" readonly
                                value="{{ $complaint->status }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" rows="3" readonly>{{ $complaint->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <a href="{{ route('complaint.show', $complaint->id) }}" class="btn btn-primary">Validasi</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
