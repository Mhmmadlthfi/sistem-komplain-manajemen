<div class="modal fade" id="repairEvidenceUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Ubah Bukti Penanganan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('handling.repair-evidence-update', $handling->id) }}" method="POST"
                enctype="multipart/form-data" id="repairEvidenceUpdateForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    {{-- <input type="hidden" name="oldRepairEvidence" value="{{ $handling->repair_evidence }}"> --}}
                    <label for="repair_evidence" class="form-label">Bukti Penanganan</label>
                    <input class="form-control @error('repair_evidence') is-invalid @enderror" type="file"
                        id="repair_evidence" name="repair_evidence" />
                    <div id="defaultFormControlHelp" class="form-text">
                        Format file yang di perbolehkan adalah jpeg, jpg, png, dan pdf dengan ukuran max: 3MB.
                    </div>
                    @error('repair_evidence')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mengambil elemen-elemen yang diperlukan
        var repairEvidenceUpdateForm = document.getElementById('repairEvidenceUpdateForm');
        var repairEvidenceInput = document.getElementById('repair_evidence');

        // Menangani submit form
        repairEvidenceUpdateForm.addEventListener('submit', function(event) {
            // Memastikan modal tidak tertutup secara otomatis
            event.preventDefault();

            // Menghapus pesan error yang mungkin sudah ada sebelumnya
            var errorMessages = repairEvidenceUpdateForm.querySelectorAll('.invalid-feedback');
            errorMessages.forEach(function(errorMessage) {
                errorMessage.remove();
            });

            // Menghapus kelas is-invalid yang mungkin sudah ada sebelumnya
            var invalidInputs = repairEvidenceUpdateForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(function(invalidInput) {
                invalidInput.classList.remove('is-invalid');
            });

            // Membuat variabel untuk menyimpan status validasi
            var isValid = true;

            // Validasi file
            var allowedExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
            var maxSize = 3 * 1024 * 1024; // 3MB
            if (repairEvidenceInput.files.length > 0) {
                var file = repairEvidenceInput.files[0];
                var fileExtension = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    isValid = false;
                    displayErrorMessage(repairEvidenceInput,
                        'Hanya file berformat jpeg, jpg, png, dan pdf yang diperbolehkan.');
                } else if (file.size > maxSize) {
                    isValid = false;
                    displayErrorMessage(repairEvidenceInput, 'Ukuran file tidak boleh lebih dari 3MB.');
                }
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
