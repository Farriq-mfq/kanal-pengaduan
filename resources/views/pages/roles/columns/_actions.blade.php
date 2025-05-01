<div class="d-flex gap-3">
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#roleEditModal">
        <i class="fas fa-edit""></i>
    </button>

    <div class="modal fade" id="roleEditModal" tabindex="-1" aria-labelledby="roleEditModal" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="roleEditModal">Edit Role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="_action" value="update">
                            <div class="form-group @error('name')
                            has-error has-feedback
                        @enderror"
                                style="text-align: left">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $role->name ?? old('name') }}" />
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
                                        <input class="form-check-input" type="checkbox" @checked($role->permissions->contains($permission->id))
                                            value="{{ $permission->id }}" id="{{ $permission->id }}"
                                            name="permissions[]">
                                        <label class="form-check-label" style="text-transform:uppercase"
                                            for="{{ $permission->id }}" name="permissions[]">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <form id="delete-form" data-title="Yakin ?" data-text="Anda akan menghapus role ini ?"
        action="{{ route('roles.destroy', $role->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
    </form>
</div>
