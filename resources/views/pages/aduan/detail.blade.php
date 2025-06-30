<x-default-layout title="Detail Aduan" :breadcrumbs="$breadcrumbs">
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href="{{ route('aduan.detail.print', ['id' => $aduan->id]) }}"><i class="fa fa-print me-2"></i>Cetak Aduan</a>
        </div>
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <h5 class="fs-4 fw-bold">

                                Uraian Aduan</h5>
                            @if ($aduan->foto != null)
                                <img src="{{ asset('storage/' . $aduan->foto) }}" class="img-fluid mb-4" alt="lampoiran">
                            @endif
                            <p>
                                {{ $aduan->uraian_pengaduan }}
                            </p>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">

                                Informasi Aduan</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nomor Aduan</th>
                                    <td>
                                        {{ $aduan->nomer_aduan }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama Pengadu</th>
                                    <td>
                                        {{ $aduan->masyarakat ? $aduan->masyarakat->name : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Aduan</th>
                                    <td>
                                        {{ $aduan->tanggal_pengaduan }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Verifikasi</th>
                                    <td>
                                        @if ($aduan->status_aduan == 'menunggu')
                                            <span><i class="fa fa-clock text-warning me-2"></i> Menunggu</span>
                                        @elseif ($aduan->status_aduan == 'proses')
                                            <span><i class="fa fa-spinner text-primary me-2"></i> Proses</span>
                                        @elseif($aduan->status_aduan == 'ditolak')
                                            <span><i class="fa fa-times text-danger me-2"></i>Ditolak</span>
                                        @elseif($aduan->status_aduan == 'selesai')
                                            <span><i class="fa fa-check text-success me-2"></i>Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Penerimaan</th>
                                    <td>
                                        {{ $aduan->tanggal_acc ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>
                                        {{ $aduan->alasan_penolakan ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Klasifikasi dan Telaah Aduan
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>
                                        Unit Kerja
                                    </th>
                                    <td>
                                        Tim Penanganan {{ $aduan->kategori->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Nama
                                    </th>
                                    <td>
                                        {{ $aduan->kategori->user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Hasil Telaah
                                    </th>
                                    <td>
                                        {{ $aduan->telaah_aduan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Klasifikasi Aduan
                                    </th>
                                    <td>
                                        {{ $aduan->klasifikasi ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Kecepatan Tindak Lanjut
                                    </th>
                                    <td>
                                        {{ $aduan->kecepatan_tindak_lanjut ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tindak Lanjut</th>
                                    <td>
                                        {{ $aduan->tindak_lanjut ? $aduan->tindak_lanjut : $aduan->text_direct_pengaduan ?? '-'}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Kepala Bidang & Kepala Dinas
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->kepala_bidang->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bagian Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->kepala_bidang->jabatan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Verifikasi Kepala Bidang</th>
                                    <td>
                                        @if ($aduan->verifikasi_kepala_bidang)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Belum Terverifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uraian Verifikasi Dari Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->uraian_tindak_lanjut_kepala_bidang ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Verifikasi Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->tanggal_tindak_lanjut_kepala_bidang ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Pemeriksaan Kepala Bidang</th>
                                    <td>
                                        <div @class([
                                            'badge',
                                            'bg-warning' => $aduan->status_tindak_lanjut_kepala_bidang === 'menunggu',
                                            'bg-success' => $aduan->status_tindak_lanjut_kepala_bidang === 'acc',
                                            'bg-danger' => $aduan->status_tindak_lanjut_kepala_bidang === 'revisi',
                                        ])>
    {{ strtoupper($aduan->status_tindak_lanjut_kepala_bidang) }}
                                        </div>
                                        @if ($aduan->status_tindak_lanjut_kepala_bidang === 'revisi' || $aduan->status_tindak_lanjut_kepala_bidang === 'acc')
                                            <button class="btn btn-sm btn-link" id="btnRevisiKepalaBidang">Lihat Riwayat
                                                Revisi Kepala Bidang</button>
                                        @endif
                                    </td>
                                </tr>
                                @if ($aduan->kepala_dinas_id)
                                    <tr>
                                        <th>Status Verifikasi Kepala Dinas</th>
                                        <td>
                                            <div @class([
                                                'badge',
                                                'bg-success' => $aduan->verifikasi_kepala_dinas,
                                                'bg-danger' => !$aduan->verifikasi_kepala_dinas,
                                            ])>
                                                {{ $aduan->verifikasi_kepala_dinas ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if ($aduan->tanggal_tindak_lanjut_kepala_dinas)
                                    <tr>
                                        <th>Status Verifikasi Kepala Dinas</th>
                                        <td>
                                            {{ $aduan->tanggal_tindak_lanjut_kepala_dinas ?? '-' }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @if (count($aduan->trackings) > 0)
                        <div class="col-12">
                            <h3 class="my-4">
                                Progress Aduan
                            </h3>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Step</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                                @foreach ($aduan->trackings as $ky => $tracking)
                                    <tr>
                                        <td>
                                            {{ $tracking->step }}
                                        </td>
                                        <td>
                                            {{ $tracking->keterangan }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($tracking->created_at)->format('d F Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalRevisiKepalaBidang">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Riwayat Revisi Kepala Bidang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#btnRevisiKepalaBidang').on('click', function () {
                $('#modalRevisiKepalaBidang').modal('show')
                $.ajax({
                    url: '{{ route('front.aduan.revisi', ':id') }}'.replace(':id', '{{ $aduan->id }}'),
                    beforeSend: function () {
                        $('#modalRevisiKepalaBidang .modal-body').html('Tunggu sebentar...')
                    },
                    success: function (res) {
                        $('#modalRevisiKepalaBidang .modal-body').html(res)
                    },
                    error: function (err) {
                        $('#modalRevisiKepalaBidang .modal-body').html('Terjadi kesalahan')
                    }
                })
            })
        </script>
    @endpush
</x-default-layout>
