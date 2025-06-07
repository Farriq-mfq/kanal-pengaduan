<form method="POST" id="formAduan">
    <div class="card shadow-lg px-3 py-5 rounded" data-aos="fade-up">
        <h3 class="text-center">Form Aduan</h3>
        <div class="card-body">
            <div class="mb-3">
                <label for="kategori">Lampiran Aduan</label>
                <input type="file" name="lampiran" id="lampiran" class="form-control">
            </div>
            <div class="mb-3">
                <label for="kategori">Kategori Aduan <span class="text-danger"
                        style="font-size: 12px">Wajib</span></label>
                <select name="kategori" id="kategori" class="form-select">
                    <option value="" selected disabled>Pilih Kategori Aduan</option>
                    <option value="1">Pengaduan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="aduan">Isi Aduan <span class="text-danger" style="font-size: 12px">Wajib</span></label>
                <textarea name="aduan" id="aduan" class="form-control" cols="30" rows="7"
                    placeholder="Masukan isi aduan dengan jelas dan detail"></textarea>
            </div>
            <div class="mb-3 d-grid">
                <button type="submit" class="btn btn-pr py-3" id="btnAduan">
                    <i class="fa fa-paper-plane me-2"></i> Kirim Aduan
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#kategori').select2();

            const btnAduan = $('#btnAduan')
            $("#formAduan").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('front.aduan.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        btnAduan.html('<i class="fa fa-spinner fa-spin"></i>');
                        btnAduan.prop('disabled', true);
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Aduan Berhasil Dikirim',
                            timer: 1500
                        })
                        $('#formAduan').trigger('reset');

                        window.location.href = "{{ route('front.aduan.tracking') }}" +
                            '?nomer_aduan=' + response.data.nomer_aduan;
                    },
                    error: function(error) {
                        if (error.status === 401) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Mengalihkan ke halaman login',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            Swal.showLoading();
                            window.location.href = "{{ route('front.login') }}";

                            return;
                        };
                        Swal.fire({
                            icon: 'error',
                            title: error.responseJSON.message,
                            timer: 1500
                        })
                    },
                    complete: function() {
                        btnAduan.html('<i class="fa fa-paper-plane me-2"></i> Kirim Aduan');
                        btnAduan.prop('disabled', false);
                    }
                })
            })
        })
    </script>
@endpush
