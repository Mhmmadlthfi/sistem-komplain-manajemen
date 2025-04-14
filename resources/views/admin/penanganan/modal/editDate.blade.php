<!-- Modal Form Penanganan -->
<div class="modal fade" id="editDateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Ubah Tanggal Penanganan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('handling.update', $handling->id) }}" class="mb-3" id="formEditDate"
                    method="POST" novalidate>
                    @method('PATCH')
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="handling_date" class="form-label">Tanggal Penanganan</label>
                            <input required class="form-control @error('handling_date') is-invalid @enderror"
                                type="date" value="{{ old('handling_date', date('Y-m-d')) }}" id="handlingDate"
                                name="handling_date" />
                            @error('handling_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if (!$errors->has('handling_date'))
                                <div id="defaultFormControlHelp" class="form-text">
                                    ini digunakan untuk mengubah tanggal penanganan jika terjadi kesalahan pada saat
                                    input
                                    tanggal penanganan. Jika anda ingin menjadwalkan ulang penanganan lakukan di bagian
                                    "Penjadwalan Ulang" supaya status penanganan berubah.
                                </div>
                            @endif
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
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
        var handlingForm = document.getElementById('formEditDate');
        var handlingDateInput = document.getElementById('handlingDate');

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

            // Validasi Tanggal Penanganan
            var currentDate = new Date();
            var handlingDate = new Date(handlingDateInput.value);

            currentDate.setHours(0, 0, 0, 0);
            handlingDate.setHours(1, 0, 0, 0);

            if (handlingDate <= currentDate) {
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
