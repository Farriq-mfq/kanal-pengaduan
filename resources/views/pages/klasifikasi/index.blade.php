<x-default-layout title="Klasifikasi" :breadcrumbs="$breadcrumbs">

    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12 justify-content-end d-flex">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#klasifikasiAddModal">
                        <i class="fas fa-plus""></i> Tambah Klasifikasi
                    </button>
                </div>
                <div class="col-12">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="klasifikasiAddModal" tabindex="-1" aria-labelledby="klasifikasiAddModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('klasifikasi.store') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="klasifikasiAddModal">Tambah Klasifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="_action" value="create">
                            <div class="form-group @error('name')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" />
                                @error('name')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>

        @push('scripts')
            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

            <script>
                $(document).ready(function() {
                    @if ($errors->any() && old('_action') == 'create')
                        $('#klasifikasiAddModal').modal("show");
                    @endif

                    $('#klasifikasi-table').DataTable().on('draw.dt', function() {
                        @if ($errors->any() && old('_action') == 'update')
                            swal({
                                title: "Error",
                                text: "{{ $errors->first() }}",
                                icon: "error",
                                buttons: false,
                                dangerMode: true,
                            })
                            $("#klasifikasiEditModal-{{ old('_id') }}").modal("show");
                        @endif
                    })
                })
            </script>
        @endpush
</x-default-layout>
