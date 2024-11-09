@extends('admin.layouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Kelola User / Data User /</span> Edit Data User
        </h5>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Data User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('manage-users.update', $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_staff">No Petugas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('no_staff') is-invalid @enderror"
                                    id="no_staff" name="no_staff" placeholder="01001"
                                    value="{{ old('no_staff', $user->no_staff) }}" required />
                                @if ($errors->has('no_staff'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('no_staff') }}
                                    </div>
                                @else
                                    <div class="form-text">No petugas harus berupa angka & berjumlah 5 karakter.</div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" autocomplete="name" placeholder="Luthfi"
                                    value="{{ old('name', $user->name) }}" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" id="email" name="email" autocomplete="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="luthfiii@gmail.com" value="{{ old('email', $user->email) }}" required />
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @else
                                    <div class="form-text">Inputkan alamat email yang valid.</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="telp">No Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" id="telp"
                                    class="form-control phone-mask @error('telp') is-invalid @enderror"
                                    placeholder="089384757384" name="telp" value="{{ old('telp', $user->telp) }}"
                                    required />
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select required class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" aria-label="Default select example">
                                    <option selected disabled>Pilih Role</option>
                                    @foreach ($roles as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">Status User</div>
                            <div class="col-sm-10 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="userStatus" name="status"
                                    value="1" {{ $user->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="userStatus" id="switchLabel">
                                    {{ $user->status ? 'Aktif' : 'Tidak Aktif' }}
                                </label>
                            </div>
                        </div>
                        <div class="row mb-3 form-password-toggle">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="basic-default-password" />
                                    <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                            class="bx bx-hide"></i></span>
                                </div>
                                <div class="form-text">Jika password tidak ingin diubah, biarkan kosong.
                                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkbox = document.getElementById('userStatus');
            var label = document.getElementById('switchLabel');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    label.textContent = 'Aktif';
                } else {
                    label.textContent = 'Tidak Aktif';
                }
            });
        });
    </script>
@endsection
