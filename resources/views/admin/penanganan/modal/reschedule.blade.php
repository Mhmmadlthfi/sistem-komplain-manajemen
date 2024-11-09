{{-- Hidden --}}
<div class="row">
    <div class="col mb-3">
        <input required type="hidden" id="handling_date" name="handling_date" class="form-control" readonly
            value="{{ $handling->handling_date }}" />
    </div>
</div>
{{-- / Hidden --}}

<!-- Modal Form Penanganan -->
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Penjadwalan Ulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('handling.reschedule', $handling->id) }}" class="mb-3" id="formAuthentication"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col mb-3">
                            <label for="reschedule_date" class="form-label">Tanggal Penjadwalan Ulang</label>
                            <input class="form-control @error('reschedule_date') is-invalid @enderror" type="date"
                                value="{{ old('reschedule_date') }}" id="reschedule_date" name="reschedule_date" />
                            @error('reschedule_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
        var rescheduleForm = document.getElementById('formAuthentication');
        var rescheduleDateInput = document.getElementById('reschedule_date');
        var handlingDateInput = document.getElementById('handling_date');
        var descriptionInput = document.getElementById('description');

        // Menangani submit form
        rescheduleForm.addEventListener('submit', function(event) {
            // Memastikan modal tidak tertutup secara otomatis
            event.preventDefault();

            // Menghapus pesan error yang mungkin sudah ada sebelumnya
            var errorMessages = document.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(function(errorMessage) {
                errorMessage.remove();
            });

            // Membuat variabel untuk menyimpan status validasi
            var isValid = true;

            // Validasi Tanggal Penjadwalan Ulang
            if (!rescheduleDateInput.value) {
                isValid = false;
                displayErrorMessage(rescheduleDateInput, 'Tanggal penjadwalan ulang wajib diatur.');
            } else {
                var handlingDate = new Date(handlingDateInput.value);
                var rescheduleDate = new Date(rescheduleDateInput.value);
                var currentDate = new Date();

                currentDate.setHours(0, 0, 0, 0);
                handlingDate.setHours(0, 0, 0, 0);
                rescheduleDate.setHours(1, 0, 0, 0);

                if (rescheduleDate < handlingDate || rescheduleDate < currentDate) {
                    isValid = false;
                    displayErrorMessage(rescheduleDateInput,
                        'Tanggal penjadwalan ulang tidak boleh kurang dari tanggal penanganan dan kurang dari tanggal hari ini.'
                    );
                }
            }

            // Validasi Deskripsi
            if (!descriptionInput.value) {
                isValid = false;
                displayErrorMessage(descriptionInput, 'Deskripsi wajib diisi.');
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
