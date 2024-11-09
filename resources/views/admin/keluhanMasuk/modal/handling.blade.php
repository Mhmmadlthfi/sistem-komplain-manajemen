<!-- Modal Form Penanganan -->
<div class="modal fade" id="handlingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Penanganan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('complaint.handling-store', $complaint->id) }}" class="mb-3"
                    id="formAuthentication" method="POST">
                    @csrf
                    {{-- Hidden --}}
                    @if ($sale)
                        <div class="row">
                            <div class="col">
                                <input required type="hidden" id="sale_id" name="sale_id" class="form-control"
                                    readonly value="{{ $sale->id }}" />
                            </div>
                        </div>
                    @endif
                    {{-- / Hidden --}}

                    <div class="row mb-3">
                        <div class="col">
                            <label for="user_id" class="form-label">Teknisi</label>
                            <select required class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                name="user_id" aria-label="Default select example">
                                <option selected disabled value="">Pilih Teknisi</option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}">{{ $technician->no_staff }} |
                                        {{ $technician->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="handling_date" class="form-label">Tanggal Penanganan</label>
                            <input required class="form-control @error('handling_date') is-invalid @enderror"
                                type="date" value="{{ old('handling_date') }}" id="handling_date"
                                name="handling_date" />
                            @error('handling_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Trigger Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mengambil elemen-elemen yang diperlukan
        var handlingForm = document.getElementById('formAuthentication');
        var technicianSelect = document.getElementById('user_id');
        var handlingDateInput = document.getElementById('handling_date');

        // Menangani submit form
        handlingForm.addEventListener('submit', function(event) {
            // Memastikan modal tidak tertutup secara otomatis
            event.preventDefault();

            // Menghapus pesan error yang mungkin sudah ada sebelumnya
            var errorMessages = document.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(function(errorMessage) {
                errorMessage.remove();
            });

            // Membuat variabel untuk menyimpan status validasi
            var isValid = true;

            // Validasi Pilihan Teknisi
            if (!technicianSelect.value) {
                isValid = false;
                displayErrorMessage(technicianSelect, 'Pilih Teknisi Terlebih Dahulu.');
            }

            // Validasi Tanggal Penanganan
            var currentDate = new Date();
            var handlingDate = new Date(handlingDateInput.value);

            currentDate.setHours(0, 0, 0, 0);
            handlingDate.setHours(1, 0, 0, 0);

            if (handlingDate < currentDate) {
                isValid = false;
                displayErrorMessage(handlingDateInput,
                    'Tanggal penanganan tidak boleh kurang dari tanggal hari ini.');
            }

            // Jika semua validasi gagal, hentikan pengiriman form
            if (!isValid) {
                return false;
            }

            // Jika semua validasi berhasil, submit form
            this.submit();
        });

        // Fungsi untuk menampilkan pesan error
        function displayErrorMessage(inputElement, message) {
            var errorMessage = document.createElement('div');
            errorMessage.className = 'invalid-feedback';
            errorMessage.textContent = message;
            inputElement.classList.add('is-invalid');
            inputElement.parentNode.appendChild(errorMessage);
        }
    });
</script>
