<div>
    <p class="mb-2 fs-5">Sudah pernah melaporkan di kanal lain? Cek kode aduan di sini.</p>

    <form class="d-md-flex d-grid gap-4" method="GET" action="{{ route('front.aduan.tracking') }}">
        <input type="text" name="nomer_aduan" class="form-control py-3 shadow-sm" required
            value="{{ request('nomer_aduan') }}" placeholder="Contoh : ADUAN-xxx">
        <button class="btn btn-pr">
            <i class="fa fa-search me-2"></i> Lacak Aduan
        </button>
    </form>
</div>
