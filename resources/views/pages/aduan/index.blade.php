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
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    @role('kepala bidang')
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
                                    Teruskan Ke Kepala Dinas
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
    @endrole
    @role('tim penanganan')
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
    @endrole

    @role('tim penanganan')
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
                            <div class="mb-3">
                                <textarea class="form-control" name="tindak_lanjut" cols="30" rows="5"
                                    placeholder="Tuliskan Catatan Tindak Lanjut"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="kepala_bidang_id">Pilih Kepala Bidang Yang Menindaklanjuti</label>
                                <select name="kepala_bidang_id" id="kepala_bidang_id" class="form-control">
                                    <option value="">Pilih Kepala Bidang Yang Menindaklanjuti</option>
                                    @foreach ($kepala_bidang as $kb)
                                        <option value="{{ $kb->id }}">
                                            {{ $kb->name }} ({{ $kb->jabatan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kecepatan_tindak_lanjut">Pilih Kepala Bidang Yang Menindaklanjuti</label>
                                <div class="form-control" id="kecepatan_tindak_lanjut">
                                    <select name="kecepatan_tindak_lanjut" id="kecepatan_tindak_lanjut"
                                        class="form-control">
                                        <option value="Biasa">Biasa</option>
                                        <option value="Segera">Segera</option>
                                        <option value="Amat Segera">Amat Segera</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnTindakLanjut">
                                Tindak Lanjuti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endrole

    @role('tim penanganan')
        <div class="modal fade" tabindex="-1" id="modalTelaahAduan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Telaah aduan dan Mengklasifikasikan aduan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formTelaahAduan" method="POST">
                        <div class="modal-body">
                            <textarea class="form-control" name="telaah" cols="30" rows="5" placeholder="Tuliskan hasil telaah"></textarea>
                            <div class="form-control mt-3">
                                <select name="klasifikasi_aduan" id="klasifikasi_aduan" class="form-control">
                                    <option value="" selected disabled>Pilih klasifikasi</option>
                                    @foreach ($klasifikasi as $kf)
                                        <option value="{{ $kf->klasifikasi }}">
                                            {{ $kf->klasifikasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnTelaahAduan">
                                Telaah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endrole


    {{-- @role('tim penanganan')
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
    @endrole --}}
    @role('kepala bidang')
        <div class="modal fade" tabindex="-1" id="modalRevisiTindakLanjut">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Revisi Tindak Lanjut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formRevisiTindakLanjut" method="POST">
                        <div class="modal-body">
                            <textarea name="revisi" class="form-control" id="revisi" cols="30" rows="5"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnRevisiTindakLanjut">
                                Revisi Tindak Lanjut
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endrole

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
                // // teruskan
                // $(document).on("click", "#teruskan_aduan", function() {
                //     const form = $("#formTeruskan");
                //     form.attr('action', "{{ route('aduan.continue', ':id') }}".replace(':id', $(this).data(
                //         'id')))
                //     $("#modalTeruskan").modal('show');
                // })
                // // continue aduan
                // $("#formTeruskan").on("submit", function(e) {
                //     e.preventDefault();

                //     const button = $("#btnTeruskan");
                //     $.ajax({
                //         method: "PATCH",
                //         url: $(this).attr('action'),
                //         data: {
                //             _token: "{{ csrf_token() }}",
                //             kepala_bidang_id: $("select[name=kepala_bidang_id]").val(),
                //         },
                //         beforeSend: function() {
                //             button.attr('disabled', true)
                //             button.html(
                //                 '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                //             )
                //         },
                //         success: function(res) {
                //             if (res.success) {
                //                 swal("Berhasil", res.message, "success");
                //                 location.reload();
                //             }
                //         },
                //         error: function(err) {
                //             if (err.responseJSON.message) {
                //                 swal("Gagal", err.responseJSON.message, "error");
                //                 return;
                //             }
                //             swal("Gagal", "Terjadi kesalahan", "error");
                //         },
                //         complete: function() {
                //             button.attr('disabled', false)
                //             button.html('Teruskan')
                //         },
                //     })
                // })


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

                    const button = $("#btnTindakLanjut");
                    button.html("Tindak Lanjuti")
                    $.ajax({
                        type: "GET",
                        url: "{{ route('aduan.kepala_bidang', ':id') }}".replace(':id', $(this).data(
                            'id')),
                        beforeSend: function() {
                            button.attr('disabled', true)
                            button.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            )
                        },
                        success: function(res) {
                            if (res.success) {
                                $("textarea[name=tindak_lanjut]").val(res.data.tindak_lanjut)
                                $("select[name=kecepatan_tindak_lanjut]").val(res.data
                                    .kecepatan_tindak_lanjut)
                                $("select[name=kepala_bidang_id]").val(res.data.kepala_bidang_id)
                                if (res.data.kepala_bidang_id) {
                                    button.html("Update Tindak Lanjut")
                                }else{
                                    button.html("Tindak Lanjuti")
                                }
                            }
                        },
                        complete: function() {
                            button.attr('disabled', false)
                        }
                    })
                    $("#modalTindakLanjut").modal('show');
                });

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
                            kepala_bidang_id: $("select[name=kepala_bidang_id]").val()
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
                            button.html('Tindak Lanjuti')
                        },
                    })
                });
                // telaah aduan
                $(document).on("click", "#telaah_aduan", function() {
                    $("#modalTelaahAduan").modal("show")
                    $("#formTelaahAduan").attr('action', "{{ route('aduan.telaah', ':id') }}".replace(':id', $(
                        this).data('id')))
                })

                $("#formTelaahAduan").on("submit", function(e) {
                    e.preventDefault();
                    const btn = $("#btnTelaahAduan");
                    $.ajax({
                        type: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            telaah: $("textarea[name=telaah]").val(),
                            klasifikasi: $("select[name=klasifikasi_aduan]").val(),
                        },
                        beforeSend: function() {
                            btn.attr("disabled", true);
                            btn.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                            );
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
                            btn.attr("disabled", false);
                            btn.html("Telaah");
                        },
                    })
                })


                $(document).on("click", "#revisi_tindak_lanjut", function() {
                    const form = $("#formRevisiTindakLanjut");
                    form.attr('action', "{{ route('aduan.revisi_tindak_lanjut', ':id') }}".replace(':id', $(
                        this).data(
                        'id')))
                    $("#modalRevisiTindakLanjut").modal('show');
                })

                $("#formRevisiTindakLanjut").on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnRevisiTindakLanjut");
                    $.ajax({
                        type: "PATCH",
                        url: $(this).attr('action'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            keterangan: $("textarea[name=revisi]").val(),
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
                            button.html('Revisi Tindak Lanjut')
                        },
                    })
                })
            })
        </script>
    @endpush
</x-default-layout>
