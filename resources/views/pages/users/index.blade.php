<x-default-layout title="Users" :breadcrumbs="$breadcrumbs">

    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12 justify-content-end d-flex">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userAddModal">
                        <i class="fas fa-plus""></i> Tambah User
                    </button>
                </div>
                <div class="col-12">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userAddModal" tabindex="-1" aria-labelledby="userAddModal" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userAddModal">Tambah User</h1>
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
                            <div class="form-group @error('email')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" />
                                @error('email')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('jabatan')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    value="{{ old('jabatan') }}" />
                                @error('jabatan')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('password')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    value="{{ old('password') }}" />
                                @error('password')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('confirmed_password')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="confirmed_password">Konfirmasi Password</label>
                                <input type="text" class="form-control" id="confirmed_password"
                                    name="confirmed_password" value="{{ old('confirmed_password') }}" />
                                @error('confirmed_password')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('role_id')
                                has-error has-feedback
                            @enderror"
                                style="text-align: left">
                                <label for="role">Role</label>
                                <select name="role_id" id="role" class="form-control">
                                    <option value="" selected>-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected($role->id == old('role_id'))>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
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
                        $('#userAddModal').modal("show");
                    @endif

                    $('#users-table').DataTable().on('draw.dt', function() {
                        @if ($errors->any() && old('_action') == 'update')
                            $('#userEditModal').modal("show");
                        @endif
                    })
                })
            </script>
        @endpush
</x-default-layout>
