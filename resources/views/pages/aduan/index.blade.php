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
                    swal({
                        title: "Yakin ?",
                        text: "Anda akan menolak aduan ini ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ["Batal", "Tolak"],
                    }).then((accept) => {
                        if (accept) {
                            const id = $(this).data('id');
                            const url = "{{ route('aduan.reject', ':id') }}".replace(':id', id);
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
            })
        </script>
    @endpush
</x-default-layout>
