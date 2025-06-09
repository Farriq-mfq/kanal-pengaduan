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
        @can('aduan accept')
            @if ($aduan->status_aduan === 'menunggu')
                <li id="accept_aduan" data-id="{{ $aduan->id }}">
                    <button class="dropdown-item fs-5 text-success" title="Lanjut"><i
                            class="fas fa-check me-2"></i>Terima</button>
                </li>
            @endif
        @endcan
        @can('aduan reject')
            @if ($aduan->status_aduan === 'menunggu')
                <li id="reject_aduan" data-id="{{ $aduan->id }}">
                    <button class="dropdown-item fs-5 text-danger" title="Tolak">
                        <i class="fas fa-times me-2"></i> Tolak
                    </button>
                </li>
            @endif
        @endcan
        {{-- kepala bidang --}}
        @role('kepala bidang')
            @if (
                $aduan->status_aduan === 'proses' &&
                    $aduan->kepala_bidang_id === auth()->user()->id &&
                    !$aduan->verifikasi_kepala_bidang)
                <li id="verifikasi_aduan_kepala_bidang" data-id="{{ $aduan->id }}">
                    <button class="dropdown-item fs-5 text-secondary" title="Teruskan">
                        <i class="fas fa-edit me-2"></i> Verifikasi Kepala Bidang
                    </button>
                </li>
            @endif
        @endrole
        @role('kepala bidang')
            @if (
                $aduan->status_aduan === 'proses' &&
                    $aduan->kepala_bidang_id === auth()->user()->id &&
                    !$aduan->verifikasi_kepala_bidang)
                <li id="revisi_tindak_lanjut" data-id="{{ $aduan->id }}">
                    <button class="dropdown-item fs-5 text-danger" title="Revisi tindak lanjut">
                        <i class="fas fa-edit me-2"></i> Revisi
                    </button>
                </li>
            @endif
        @endrole
        {{-- tim penanganan --}}
        {{-- @role('tim penanganan')
            @if ($aduan->status_aduan === 'proses' && $aduan->kepala_bidang_id == null && $aduan->telaah_aduan !== null)
                <li id="teruskan_aduan" data-id="{{ $aduan->id }}">
                    <button class="dropdown-item fs-5 text-secondary" title="Teruskan">
                        <i class="fas fa-arrow-up me-2"></i> Teruskan
                    </button>
                </li>
            @endif
        @endrole --}}
        @role('tim penanganan')
            @if ($aduan->status_aduan === 'proses' && $aduan->kepala_bidang_id === null && $aduan->telaah_aduan !== null)
                <li>
                    <button class="dropdown-item fs-5 text-dark" title="Jawab Langsung" id="direct_aduan"
                        data-id="{{ $aduan->id }}">
                        <i class="fas fa-reply me-2"></i> Jawab Langsung
                    </button>
                </li>
            @endif
        @endrole
        @role('tim penanganan')
            @if (
                ($aduan->status_aduan === 'proses' && $aduan->kepala_bidang_id === null && $aduan->telaah_aduan !== null) ||
                    $aduan->status_tindak_lanjut_kepala_bidang === 'revisi')
                <li>
                    <button class="dropdown-item fs-5 text-warning" title="Tambahkan Tindak Lanjut" id="tindak_lanjut"
                        data-id="{{ $aduan->id }}">
                        <i class="fas fa-edit me-2"></i> Tindak Lanjut
                    </button>
                </li>
            @endif
        @endrole

        @role('tim penanganan')
            @if ($aduan->status_aduan === 'proses' && $aduan->kepala_bidang_id === null && $aduan->telaah_aduan === null)
                <li>
                    <button class="dropdown-item fs-5 text-secondary" id="telaah_aduan" data-id="{{ $aduan->id }}"
                        title="Tambahkan Telaah Aduan">
                        <i class="fas fa-plus me-2"></i> Telaah Aduan
                    </button>
                </li>
            @endif
        @endrole
        @can('aduan delete')
            @if ($aduan->status_aduan === 'menunggu')
                <li>
                    <button class="dropdown-item fs-5 text-danger" title="Hapus Aduan" id="hapus_aduan"
                        data-id="{{ $aduan->id }}">
                        <i class="fas fa-trash me-2"></i> Hapus
                    </button>
                </li>
            @endif
        @endcan

        @role('kepala dinas')
            @if ($aduan->status_aduan === 'proses' && $aduan->kepala_bidang_id !== null)
                <li>
                    <button class="dropdown-item fs-5 text-success" id="verifikasi_kepala_dinas" title="Verifikasi"
                        data-id="{{ $aduan->id }}"><i class="fas fa-edit me-2"></i>Verifikasi</button>
                </li>
            @endif
        @endrole

    </ul>
</div>
