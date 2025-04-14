@foreach ($users as $user)
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Detail Data User : {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="no_staff" class="form-label">No Petugas</label>
                            <input type="text" id="no_staff" class="form-control" readonly
                                value="{{ $user->no_staff }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" id="name" autocomplete="name" class="form-control" readonly
                                value="{{ $user->name }}" />
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col mb-0">
                            <label for="telp" class="form-label">No Telepon</label>
                            <input type="text" id="telp" class="form-control" readonly
                                value="{{ $user->telp }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" autocomplete="email" class="form-control" readonly
                                value="{{ $user->email }}" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" id="role" class="form-control" readonly
                                value="{{ $user->role }}" />
                        </div>
                        <div class="col mb-0">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" id="status" class="form-control" readonly
                                value="{{ $user->status ? 'Aktif' : 'Tidak Aktif' }}" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    {{-- <a href="#" class="btn btn-primary">Validasi</a> --}}
                </div>
            </div>
        </div>
    </div>
@endforeach
