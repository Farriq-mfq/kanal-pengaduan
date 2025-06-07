@if ($aduan->kepala_bidang_id)
    <div @class([
        'badge',
        'bg-warning' => $aduan->status_tindak_lanjut_kepala_bidang === 'menunggu',
        'bg-success' => $aduan->status_tindak_lanjut_kepala_bidang === 'acc',
        'bg-danger' => $aduan->status_tindak_lanjut_kepala_bidang === 'revisi',
    ])>
        {{ strtoupper($aduan->status_tindak_lanjut_kepala_bidang) }}
    </div>
@else
    <div>-</div>
@endif
