<div class="d-flex gap-3">
    @can('klasifikasi update')
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#klasifikasiEditModal-{{ $klasifikasi->id }}">
            <i class="fas fa-edit""></i>
        </button>

        <div class="modal fade" id="klasifikasiEditModal-{{ $klasifikasi->id }}" tabindex="-1"
            aria-labelledby="klasifikasiEditModal-{{ $klasifikasi->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('klasifikasi.update', $klasifikasi->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="klasifikasiEditModal-{{ $klasifikasi->id }}">Edit Klasifikasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <input type="hidden" name="id" value="{{ $klasifikasi->id }}">">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="_id" value="{{ $klasifikasi->id }}">
                                <input type="hidden" name="_action" value="update">
                                <div class="form-group @error('name')
                       has-error has-feedback
                   @enderror"
                                    style="text-align: left">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $klasifikasi->klasifikasi ?? old('klasifikasi') }}" />
                                    @error('name')
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
    @endcan

    @can('klasifikasi delete')
        {{-- Delete --}}
        <form id="delete-form" data-title="Yakin ?" data-text="Anda akan menghapus klasifikasi ini ?"
            action="{{ route('klasifikasi.destroy', $klasifikasi->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
        </form>
    @endcan
</div>
