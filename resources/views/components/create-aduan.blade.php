<form action="">
    <div class="card shadow-lg px-3 py-5 rounded" data-aos="fade-up">
        <h3 class="text-center">Form Aduan</h3>
        <div class="card-body">
            <div class="mb-3">
                <label for="kategori">Lampiran Aduan</label>
                <input type="file" name="lampiran" id="lampiran" class="form-control">
            </div>
            <div class="mb-3">
                <label for="kategori">Kategori Aduan <span class="text-danger" style="font-size: 12px">Wajib</span></label>
                <select name="kategori" id="kategori" class="form-select">
                    <option value="" selected disabled>Pilih Kategori Aduan</option>
                    <option value="1">Pengaduan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="aduan">Isi Aduan <span class="text-danger" style="font-size: 12px">Wajib</span></label>
                <textarea name="aduan" id="aduan" class="form-control" cols="30" rows="7" placeholder="Masukan isi aduan dengan jelas dan detail"></textarea>
            </div>
            <div class="mb-3 d-grid">
                <button type="submit" class="btn btn-pr py-3">
                    <i class="fa fa-paper-plane me-2"></i> Kirim Aduan
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    {{-- <script>alert("ok")</script> --}}
@endpush
