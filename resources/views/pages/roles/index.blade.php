<x-default-layout title="Hak Akses" :breadcrumbs="$breadcrumbs">

    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12 justify-content-end d-flex">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleAddModal">
                        <i class="fas fa-plus""></i> Tambah Role
                    </button>
                </div>
                <div class="col-12">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleAddModal" tabindex="-1" aria-labelledby="roleAddModal" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="roleAddModal">Tambah Role</h1>
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
                            <div class="form-group d-flex flex-wrap border m-2 @error('permissions')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}"
                                            id="{{ $permission->id }}-permission" name="permissions[]">
                                        <label class="form-check-label" style="text-transform:uppercase"
                                            for="{{ $permission->id }}-permission" name="permissions[]">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('permissions')
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
                        $('#roleAddModal').modal("show");
                    @endif

                    $('#roles-table').DataTable().on('draw.dt', function() {
                        @if ($errors->any() && old('_action') == 'update')
                            $('#roleEditModal').modal("show");
                        @endif
                    })
                })
            </script>
        @endpush
</x-default-layout>
