<x-default-layout title="Kategori" :breadcrumbs="$breadcrumbs">
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    @endpush
    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12 justify-content-end d-flex">
                    @can('kategori create')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kategoriAddModal">
                            <i class="fas fa-plus""></i> Tambah Kategori
                                                            </button>
                    @endcan
                </div>
                <div class=" col-12">
                            {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @can('kategori create')
        <div class="modal fade" id="kategoriAddModal" tabindex="-1" aria-labelledby="kategoriAddModal" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('kategori.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="kategoriAddModal">Tambah Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="_action" value="create">
                                <div class="form-group @error('name')
                                    has-error has-feedback
                                @enderror" style="text-align: left">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <small class="form-text text-muted text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea id="panduan" name="panduan"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </div>
                </form>
            </div>
    @endcan

        @push('scripts')
            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#panduan').summernote({
                        height: 300
                    })
                    @if ($errors->any() && old('_action') == 'create')
                        $('#kategoriAddModal').modal("show");
                    @endif

                    $('#kategori-table').DataTable().on('draw.dt', function () {
                        @if ($errors->any() && old('_action') == 'update')
                            swal({
                                title: "Error",
                                text: "{{ $errors->first() }}",
                                icon: "error",
                                buttons: false,
                                dangerMode: true,
                            })
                            $("#kategoriEditModal-{{ old('_id') }}").modal("show");
                        @endif
                                                        })
                })
            </script>
        @endpush
</x-default-layout>
