<style>
    .timeline {
        position: relative;
        padding: 2rem 0;
        list-style: none;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #0d6efd;
        left: 30px;
        margin-left: -2px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 60px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #0d6efd;
        left: 22px;
        top: 0;
    }
</style>

<h3 class="my-4">Detail Aduan</h3>
<table class="table table-bordered table-striped">
    <tr>
        <th>Nomer Aduan</th>
        <td>
            {{ $aduan->nomer_aduan }}
        </td>
    </tr>
    <tr>
        <th>
            Nama Pengadu
        </th>
        <td>
            {{ $aduan->masyarakat ? $aduan->masyarakat->name : '-' }}
        </td>
    </tr>
    <tr>
        <th>Tanggal Pengaduan</th>
        <td>
            {{ $aduan->tanggal_pengaduan }}
        </td>
    </tr>
    <tr>
        <th>Klasifikasi Aduan</th>
        <td>
            {{ $aduan->klasifikasi ?? '-' }}
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            @if ($aduan->status_aduan == 'menunggu')
                <span><i class="fa fa-clock text-warning me-2"></i> Menunggu</span>
            @elseif ($aduan->status_aduan == 'proses')
                <span><i class="fa fa-info text-priary me-2"></i> Proses</span>
            @elseif($aduan->status_aduan == 'ditolak')
                <span><i class="fa fa-times text-danger me-2"></i>Ditolak</span>
            @elseif($aduan->status_aduan == 'selesai')
                <span><i class="fa fa-check text-success me-2"></i>Seleseai</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Detail</th>
        <td>
            <a href="{{ route('aduan.detail', $aduan->id) }}" class="btn btn-primary">Lihat Detail</a>
        </td>
    </tr>
</table>

<h4 class="mt-5">
    Timeline
</h4>
<section class="bsb-timeline-1 py-5 py-xl-8">
    <div class="row">
        <div class="col-10 col-md-8 col-xl-6">

            <ul class="timeline">
                @foreach ($aduan->trackings as $tracking)
                    <li class="timeline-item">
                        <div class="timeline-body">
                            <div class="timeline-content">
                                <div @class([
                                    'card',
                                    'border',
                                    'border-primary' => $tracking->status == 'proses',
                                    'border-warning' => $tracking->status == 'menunggu',
                                    'border-danger' => $tracking->status == 'ditolak',
                                    'border-success' => $tracking->status == 'selesai',
                                ])>
                                    <div class="card-body">
                                        <h5 class="card-subtitle mb-1">
                                            {{ \Carbon\Carbon::parse($tracking->created_at)->format('d F Y H:i') }}
                                        </h5>
                                        <h2 class="card-title mb-3">
                                            {{ $tracking->step }}
                                        </h2>
                                        <p class="card-text m-0">
                                            {{ $tracking->keterangan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</section>
