<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Tracking Aduan
                    </h1>
                    <p>Informasi Kemajuan Pengaduan Anda</p>
                </div>
            </div>
            <div class="row mt-4 justify-content-center" data-aos="zoom-out">
                <x-tracking-input></x-tracking-input>
            </div>
            <div class="row">
                <div class="col-12">
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
                            <th>Status</th>
                            <td>
                                @if ($aduan->status_aduan == 'menunggu')
                                    <span><i class="fa fa-clock text-warning me-2"></i> Menunggu</span>
                                @elseif ($aduan->status_aduan == 'proses')
                                    <span><i class="fa fa-spinner text-primary me-2"></i> Proses</span>
                                @elseif($aduan->status_aduan == 'ditolak')
                                    <span><i class="fa fa-times text-danger me-2"></i>Ditolak</span>
                                @elseif($aduan->status_aduan == 'selesai')
                                    <span><i class="fa fa-check text-success me-2"></i>Seleseai</span>
                                @endif
                            </td>
                        </tr>
                        @if ($aduan->status_aduan == 'ditolak')
                            <tr>
                                <th>Alasan Penolakan</th>
                                <td>
                                    {{ $aduan->alasan_penolakan ?? '-' }}
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-12">
                    <h3 class="my-4">Uraian Pengaduan</h3>
                    <table class="table">
                        <tr>
                            <td>
                                {{ $aduan->uraian_pengaduan ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
                @if ($aduan->telaah_aduan)
                    <div class="col-12">
                        <h3 class="my-4">Telaah Aduan</h3>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Uraian Telaah</th>
                                <td>
                                    {{ $aduan->telaah_aduan ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Klasifikasi Aduan</th>
                                <td>
                                    {{ $aduan->klasifikasi ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
                @if ($aduan->text_direct_pengaduan)
                    <div class="col-12">
                        <h3 class="my-4">Jawaban Langsung</h3>
                        <table class="table">
                            <tr>
                                <td>
                                    {{ $aduan->text_direct_pengaduan ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
                @if ($aduan->tindak_lanjut)
                    <div class="col-12">
                        <h3 class="my-4">Tindak Lanjut Aduan</h3>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Uraian Tindak Lanjut</th>
                                <td>
                                    {{ $aduan->tindak_lanjut ?? '-' }}
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
                                <th>Kepala Bidang</th>
                                <td>
                                    {{ $aduan->kepala_bidang ? $aduan->kepala_bidang->name : '-' }}
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
                            <tr>
                                <th>Status Verifikasi Kepala Bidang</th>
                                <td>
                                    <div @class([
                                        'badge',
                                        'bg-success' => $aduan->verifikasi_kepala_bidang,
                                        'bg-danger' => !$aduan->verifikasi_kepala_bidang,
                                    ])>
                                        {{ $aduan->verifikasi_kepala_bidang ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                    </div>
                                </td>
                            </tr>
                            @if ($aduan->uraian_tindak_lanjut_kepala_bidang)
                                <tr>
                                    <th>Uraian Verifikasi Dari Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->uraian_tindak_lanjut_kepala_bidang ?? '-' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($aduan->tanggal_tindak_lanjut_kepala_bidang)
                                <tr>
                                    <th>Tanggal Verifikasi Kepala Bidang</th>
                                    <td>
                                        {{ $aduan->tanggal_tindak_lanjut_kepala_bidang ?? '-' }}
                                    </td>
                                </tr>
                            @endif
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
                @endif

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
    </section>

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
            $('#btnRevisiKepalaBidang').on('click', function() {
                $('#modalRevisiKepalaBidang').modal('show')
                $.ajax({
                    url: '{{ route('front.aduan.revisi', ':id') }}'.replace(':id', '{{ $aduan->id }}'),
                    beforeSend: function() {
                        $('#modalRevisiKepalaBidang .modal-body').html('Tunggu sebentar...')
                    },
                    success: function(res) {
                        $('#modalRevisiKepalaBidang .modal-body').html(res)
                    },
                    error: function(err) {
                        $('#modalRevisiKepalaBidang .modal-body').html('Terjadi kesalahan')
                    }
                })
            })
        </script>
    @endpush
</x-front-layout>
