@push('styles')
    <style>
        .status-background-success td {
            background-color: #d4edda !important;
        }

        .status-background-warning td {
            background-color: #fff3cd !important;
        }

        .status-background-info td {
            background-color: #d1ecf1 !important;
        }

        .status-background-danger td {
            background-color: #f8d7da !important;
        }
    </style>
@endpush
<x-default-layout title="Daftar Aduan" :breadcrumbs="$breadcrumbs">
    <div class="card">
        <div class="card-title px-5 py-4 d-flex gap-4 flex-wrap">
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #fff3cd"></div>
                <span>Menunggu</span>
            </div>
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #d1ecf1"></div>
                <span>Proses</span>
            </div>
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #d4edda"></div>
                <span>Selesai</span>
            </div>
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #f8d7da"></div>
                <span>Tolak</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    @can('aduan continue')
        <div class="modal fade" tabindex="-1" id="modalTeruskan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Teruskan Ke Kepala Bidang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formTeruskan" method="POST">
                        <div class="modal-body">
                            <select name="kepala_bidang_id" class="form-control">
                                <option value="">Pilih Kepala Bidang</option>
                                @foreach ($kepala_bidang as $kb)
                                    <option value="{{ $kb->id }}">
                                        {{ $kb->name }} ({{ $kb->jabatan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnTeruskan">
                                Teruskan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can('aduan reject')
        <div class="modal fade" tabindex="-1" id="modalRejectAduan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tolak Aduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formRejectAduan" method="POST">
                        <div class="modal-body">
                            <textarea class="form-control" name="alasan_penolakan" cols="30" rows="5"
                                placeholder="Tuliskan Alasan Penolakan"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" id="btnRejectAduan">
                                Tolak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can('kepala bidang')
        <div class="modal fade" tabindex="-1" id="modalVerifikasiKepalaBidang">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Verifikasi Aduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formVerifikasiKepalaBidang" method="POST">
                        <div class="modal-body">
                            <textarea class="form-control" name="uraian_verifikasi" cols="30" rows="5" placeholder="Uraian Verifikasi"></textarea>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kepala_dinas"
                                    id="continueKepalaDinas">
                                <label class="form-check-label" for="continueKepalaDinas">
                                    Terukan Ke Kepala Dinas
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnVerifikasiKepalaBidang">
                                Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @can('aduan direct')
        <div class="modal fade" tabindex="-1" id="modalDirectAduan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Jawab Langsung Aduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formDirectAduan" method="POST">
                        <div class="modal-body">
                            <textarea class="form-control" name="text_direct_pengaduan" cols="30" rows="5" placeholder="Jawaban"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnDirectAduan">
                                Jawab
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('aduan tindak_lanjut')
        <div class="modal fade" tabindex="-1" id="modalTindakLanjut">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tindak Lanjut Aduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formTindakLanjut" method="POST">
                        <div class="modal-body">
                            <textarea class="form-control" name="tindak_lanjut" cols="30" rows="5"
                                placeholder="Tuliskan Tindak Lanjut"></textarea>
                                <div class="form-control">
                                    <select name="kecepatan_tindak_lanjut" id="kecepatan_tindak_lanjut" class="form-control">
                                        <option value="Biasa">Biasa</option>
                                        <option value="Segera">Segera</option>
                                        <option value="Amat Segera">Amat Segera</option>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnTindakLanjut">
                                Berikan Catatan Tindak Lanjut
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        <script>
            $(document).ready(function() {
                // hapus
                $(document).on('click', '#hapus_aduan', function() {
                    swal({
                        title: "Yakin ?",
                        text: "Ingin hapus aduan ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ["Batal", "Hapus"],
                    }).then((accept) => {
                        if (accept) {
                            const id = $(this).data('id');
                            const url = "{{ route('aduan.destroy', ':id') }}".replace(':id', id);
                            $.ajax({
                                method: "DELETE",
                                url,
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(res) {
                                    if (res.success) {
                                        swal("Berhasil", res.message, "success");
                                        location.reload();
                                    }
                                },
                                error: function(err) {
                                    swal("Gagal", err.responseJSON.message, "error");
                                }
                            })
                        }
                    })
                })
                // copy
                $(document).on('click', '#copy_nomer_aduan', function() {
                    const nomerAduan = $(this).parent().find('#nomer_aduan').text();
                    navigator.clipboard.writeText(nomerAduan);
                    swal("Berhasil", "Nomer Aduan berhasil disalin", "success");
                })
                // accept
                $(document).on("click", "#accept_aduan", function() {
                    swal({
                        title: "Yakin ?",
                        text: "Anda akan menerima aduan ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: false,
                        buttons: ["Batal", "Terima"],
                    }).then((accept) => {
                        if (accept) {
                            const id = $(this).data('id');
                            const url = "{{ route('aduan.accept', ':id') }}".replace(':id', id);
                            $.ajax({
                                method: "PATCH",
                                url,
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(res) {
                                    if (res.success) {
                                        swal("Berhasil", res.message, "success");
                                        location.reload();
                                    }
                                },
                                error: function(err) {
                                    swal("Gagal", err.responseJSON.message, "error");
                                }
                            })
                        }
                    })
                })
                // reject
                $(document).on("click", "#reject_aduan", function() {
                    $("#formRejectAduan").attr('action', "{{ route('aduan.reject', ':id') }}".replace(':id', $(
                        this).data('id')));
                    $("#modalRejectAduan").modal('show');
                })

                $("#formRejectAduan").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnRejectAduan");
                    $.ajax({
                        method: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            alasan_penolakan: $("textarea[name=alasan_penolakan]").val(),
                        },
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                swal("Berhasil", res.message, "success");
                                location.reload();
                            }
                        },
                        error: function(err) {
                            swal("Gagal", err.responseJSON.message, "error");
                        },
                        complete: function() {
                            button.attr('disabled', false)
                            button.html('Tolak')
                        }
                    })
                })
                // teruskan
                $(document).on("click", "#teruskan_aduan", function() {
                    const form = $("#formTeruskan");
                    form.attr('action', "{{ route('aduan.continue', ':id') }}".replace(':id', $(this).data(
                        'id')))
                    $("#modalTeruskan").modal('show');
                })
                // continue aduan
                $("#formTeruskan").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnTeruskan");
                    $.ajax({
                        method: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            kepala_bidang_id: $("select[name=kepala_bidang_id]").val(),
                        },
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                swal("Berhasil", res.message, "success");
                                location.reload();
                            }
                        },
                        error: function(err) {
                            if (err.responseJSON.message) {
                                swal("Gagal", err.responseJSON.message, "error");
                                return;
                            }
                            swal("Gagal", "Terjadi kesalahan", "error");
                        },
                        complete: function() {
                            button.attr('disabled', false)
                            button.html('Teruskan')
                        },
                    })
                })


                $(document).on("click", "#verifikasi_aduan_kepala_bidang", function() {
                    const form = $("#formVerifikasiKepalaBidang");
                    form.attr('action', "{{ route('aduan.verify_kepala_bidang', ':id') }}".replace(':id', $(
                        this).data(
                        'id')))
                    $("#modalVerifikasiKepalaBidang").modal('show');
                })

                $("#formVerifikasiKepalaBidang").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnVerifikasiKepalaBidang");
                    $.ajax({
                        method: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            uraian_verifikasi: $("textarea[name=uraian_verifikasi]").val(),
                            kepala_dinas: $("input[name=kepala_dinas]").is(":checked")
                        },
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                swal("Berhasil", res.message, "success");
                                location.reload();
                            }
                        },
                        error: function(err) {
                            if (err.responseJSON.message) {
                                swal("Gagal", err.responseJSON.message, "error");
                                return;
                            }
                            swal("Gagal", "Terjadi kesalahan", "error");
                        },
                        complete: function() {
                            button.attr('disabled', false)
                            button.html('Teruskan')
                        },
                    })
                })

                // direct aduan
                $(document).on("click", "#direct_aduan", function() {
                    const form = $("#formDirectAduan");
                    form.attr('action', "{{ route('aduan.direct', ':id') }}".replace(':id', $(this).data(
                        'id')))
                    $("#modalDirectAduan").modal('show');
                })

                $("#formDirectAduan").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnDirectAduan");
                    $.ajax({
                        method: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            text_direct_pengaduan: $("textarea[name=text_direct_pengaduan]").val(),
                        },
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                swal("Berhasil", res.message, "success");
                                location.reload();
                            }
                        },
                        error: function(err) {
                            if (err.responseJSON.message) {
                                swal("Gagal", err.responseJSON.message, "error");
                                return;
                            }
                            swal("Gagal", "Terjadi kesalahan", "error");
                        },
                        complete: function() {
                            button.attr('disabled', false)
                            button.html('Teruskan')
                        },
                    })
                })

                // tindak Lanjut
                $(document).on("click", "#tindak_lanjut", function() {
                    const form = $("#formTindakLanjut");
                    form.attr('action', "{{ route('aduan.tindak_lanjut', ':id') }}".replace(':id', $(this)
                        .data(
                            'id')))
                    $("#modalTindakLanjut").modal('show');
                })

                $("#formTindakLanjut").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnTindakLanjut");
                    $.ajax({
                        method: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            tindak_lanjut: $("textarea[name=tindak_lanjut]").val(),
                            kecepatan_tindak_lanjut: $("select[name=kecepatan_tindak_lanjut]").val(),
                        },
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                swal("Berhasil", res.message, "success");
                                location.reload();
                            }
                        },
                        error: function(err) {
                            if (err.responseJSON.message) {
                                swal("Gagal", err.responseJSON.message, "error");
                                return;
                            }
                            swal("Gagal", "Terjadi kesalahan", "error");
                        },
                        complete: function() {
                            button.attr('disabled', false)
                            button.html('Berikan Catatan Tindak Lanjut')
                        },
                    })
                })

            })
        </script>
    @endpush
</x-default-layout>
