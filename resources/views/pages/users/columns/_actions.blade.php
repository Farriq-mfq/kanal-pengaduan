<div class="d-flex gap-3">
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
        data-bs-target="#userEditModal-{{ $user->id }}">
        <i class="fas fa-edit""></i>
    </button>
    <button type=" button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
            data-bs-target="#userPasswordModal-{{ $user->id }}"><i class="fas fa-key"></i></button>

    <div class="modal fade" id="userPasswordModal-{{ $user->id }}" tabindex="-1"
        aria-labelledby="userPasswordModal-{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('users.update.password', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userPasswordModal-{{ $user->id }}">Ubah Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="_id" value="{{ $user->id }}">
                            <input type="hidden" name="_action" value="password">
                            <div class="form-group @error('password')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
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

    <div class="modal fade" id="userEditModal-{{ $user->id }}" tabindex="-1"
        aria-labelledby="userEditModal-{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="userEditModal-{{ $user->id }}">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="_id" value="{{ $user->id }}">
                            <input type="hidden" name="_action" value="update">
                            <div class="form-group @error('name')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name ?? old('name') }}" />
                                @error('name')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('username')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="username">Username</label>
                                <input type="username" class="form-control" id="username" name="username"
                                    value="{{ $user->username ?? old('username') }}" />
                                @error('username')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('jabatan')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    value="{{ $user->jabatan ?? old('jabatan') }}" />
                                @error('jabatan')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('kategori')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="" selected>-- Pilih Kategori -- (Jika User Sebagai Tim
                                        Penanganan)</option>
                                    @foreach ($kategori as $kt)
                                        <option value="{{ $kt->id }}" @selected($kt->id == $user->kategori_id)>
                                            {{ $kt->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group @error('role_id')
                                has-error has-feedback
                            @enderror" style="text-align: left">
                                <label for="role">Role</label>
                                <select name="role_id" id="role" class="form-control">
                                    <option value="">-- Pilih Role --</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected($role->id == $user->roles->first()->id)>
                                            {{ $role->name }}
                                        </option>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <form id="delete-form" data-title="Yakin ?" data-text="Anda akan menghapus user ini ?"
        action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
    </form>
</div>
