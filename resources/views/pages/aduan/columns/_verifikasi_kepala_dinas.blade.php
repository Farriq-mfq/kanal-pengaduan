    <div @class([
        'badge',
        'bg-success' => $aduan->verifikasi_kepala_dinas,
        'bg-danger' => !$aduan->verifikasi_kepala_dinas,
    ])>{{ $aduan->verifikasi_kepala_dinas ? 'Terverifikasi' : 'Belum Terverifikasi' }}
    </div>
