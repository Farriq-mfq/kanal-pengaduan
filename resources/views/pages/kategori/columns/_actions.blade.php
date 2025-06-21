<div class="d-flex gap-3">
    @can('kategori update')
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#kategoriEditModal-{{ $kategori->id }}">
                <i class="fas fa-edit""></i>
                        </button>

                        <div class=" modal fade" id="kategoriEditModal-{{ $kategori->id }}" tabindex="-1"
                    aria-labelledby="kategoriEditModal-{{ $kategori->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="modal-content" method="POST" action="{{ route('kategori.update', $kategori->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="kategoriEditModal-{{ $kategori->id }}">Edit Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <input type="hidden" name="id" value="{{ $kategori->id }}">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" name="_id" value="{{ $kategori->id }}">
                                        <input type="hidden" name="_action" value="update">
                                        <div class="form-group @error('name')
                                               has-error has-feedback
                                           @enderror" style="text-align: left">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $kategori->name ?? old('name') }}" />
                                            @error('name')
                                                <small class="form-text text-muted text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <textarea id="panduan_{{ $kategori->id }}" name="panduan">
                                                    {{ $kategori->panduan ?? old('panduan') }}
                                                </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
        </div>
    @endcan

<script>
    $('#panduan_{{ $kategori->id }}').summernote({
        height: 300
    })
</script>

@can('kategori delete')
    {{-- Delete --}}
    <form id="delete-form" data-title="Yakin ?" data-text="Anda akan menghapus kategori ini ?"
        action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
    </form>
@endcan
</div>
