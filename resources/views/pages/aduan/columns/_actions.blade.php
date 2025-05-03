<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenuAduan" data-bs-toggle="dropdown"
        aria-expanded="false">
        Pilih Tindakan
    </button>
    <ul class="dropdown-menu" aria-labelledby="actionMenuAduan">
        <li>
            <a href="{{ route('aduan.detail', $aduan->id) }}" class="dropdown-item fs-5 text-info" title="Detail"><i
                    class="fas fa-arrow-right me-2"></i>Detail</a>
        </li>
        <li id="accept_aduan" data-id="{{ $aduan->id }}">
            <button class="dropdown-item fs-5 text-success" title="Lanjut"><i
                    class="fas fa-check me-2"></i>Lanjut</button>
        </li>
        <li id="reject_aduan" data-id="{{ $aduan->id }}">
            <button class="dropdown-item fs-5 text-danger" title="Tolak">
                <i class="fas fa-times me-2"></i> Tolak
            </button>
        </li>
        <li>
            <button class="dropdown-item fs-5 text-secondary" title="Teruskan">
                <i class="fas fa-arrow-up me-2"></i> Teruskan
            </button>
        </li>
        <li>
            <button class="dropdown-item fs-5 text-dark" title="Jawab Langsung">
                <i class="fas fa-reply me-2"></i> Jawab Langsung
            </button>
        </li>
        <li>
            <button class="dropdown-item fs-5 text-warning" title="Perlu Tindakan">
                <i class="fas fa-exclamation me-2"></i> Perlu Tindakan
            </button>
        </li>
        <li>
            <button class="dropdown-item fs-5 text-info" title="Tambahkan Hasil Mediasi">
                <i class="fas fa-plus me-2"></i> Tambahkan Hasil Mediasi
            </button>
        </li>

    </ul>
</div>
