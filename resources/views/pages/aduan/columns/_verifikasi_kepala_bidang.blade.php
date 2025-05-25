    <div @class([
        'badge',
        'bg-success' => $aduan->verifikasi_kepala_bidang,
        'bg-danger' => !$aduan->verifikasi_kepala_bidang,
    ])>{{ $aduan->verifikasi_kepala_bidang ? 'Terverifikasi' : 'Belum Terverifikasi' }}
    </div>
