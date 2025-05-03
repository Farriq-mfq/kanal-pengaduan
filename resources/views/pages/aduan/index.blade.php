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
                <span>Diproses</span>
            </div>
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #d4edda"></div>
                <span>Disetujui</span>
            </div>
            <div class="d-flex align-items-center gap-2 fs-5">
                <div style="height: 40px;width: 40px;background-color: #f8d7da"></div>
                <span>Ditolak</span>
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
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        <script>
            $(document).ready(function() {
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
            })
        </script>
    @endpush
</x-default-layout>
