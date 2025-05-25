<x-defual<x-default-layout title="Detail Aduan" :breadcrumbs="$breadcrumbs">
    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12">
                    <div class="row">
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
                                    <th>Nama Pelapor</th>
                                    <td>
                                        Anonymous
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
                                            <span><i class="fa fa-info text-primary me-2"></i> Proses</span>
                                        @elseif($aduan->status_aduan == 'ditolak')
                                            <span><i class="fa fa-times text-danger me-2"></i>Ditolak</span>
                                        @elseif($aduan->status_aduan == 'selesai')
                                            <span><i class="fa fa-check text-success me-2"></i>Seleseai</span>
                                        @endif
                                    </td>
                                </tr>
                                @if ($aduan->text_direct_pengaduan)
                                    <tr>
                                        <th>Jawaban Langsung</th>
                                        <td>
                                            {{ $aduan->text_direct_pengaduan }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <h5 class="fs-4 fw-bold">

                                Uraian Aduan</h5>
                            <p>
                                {{ $aduan->uraian_pengaduan }}
                            </p>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Tindak Lanjut Aduan
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Alasan Penolakan</th>
                                    <td>
                                        {{ $aduan->alasan_penolakan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tindak Lanjut</th>
                                    <td>
                                        {{ $aduan->tindak_lanjut ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kecepatan Tindak Lanjut</th>
                                    <td>
                                        @if ($aduan->kecepatan_tindak_lanjut)
                                            <span class="badge bg-primary">{{ $aduan->kecepatan_tindak_lanjut }}</span>
                                        @else
                                            -
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <th>Klasifikasi</th>
                                    <td>
                                        {{ $aduan->klasifikasi ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Kepala Bidang
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama </th>
                                    <td>
                                        {{ $aduan->kepala_bidang->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bagian</th>
                                    <td>
                                        {{ $aduan->kepala_bidang->jabatan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Verifikasi</th>
                                    <td>
                                        @if ($aduan->verifikasi_kepala_bidang)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-danger">Belum Terverifikasi</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uraian Tindakan</th>
                                    <td>
                                        {{ $aduan->uraian_tindak_lanjut_kepala_bidang ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Telaah Aduan
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Hasil Telaah</th>
                                    <td>
                                        {{ $aduan->telaah_aduan ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Mediasi
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Status Mediasi</th>
                                    <td>
                                        @if ($aduan->status_mediasi)
                                            <span><i class="fa fa-check text-success me-2"></i>Dilakukan Mediasi</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mediasi</th>
                                    <td>
                                        {{ $aduan->tanggal_mediasi ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uraian Mediasi</th>
                                    <td>
                                        {{ $aduan->uraian_mediasi ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h5 class="fs-4 fw-bold">
                                Tersampaikan
                            </h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Status Disampaikan</th>
                                    <td>
                                        @if ($aduan->status_disampaikan)
                                            <span><i class="fa fa-check text-success me-2"></i>Tersampaikan</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Disampaikan</th>
                                    <td>
                                        {{ $aduan->tanggal_disampaikan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggapan Masyarakat</th>
                                    <td>
                                        {{ $aduan->tanggapan ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dilihat</th>
                                    <td>
                                        @if ($aduan->is_view)
                                            <span><i class="fa fa-check text-success me-2"></i>Dilihat</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('aduan.index') }}" class="btn btn-primary"><i class="fa fa-print me-2"></i>
                            Cetak Surat Aduan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </x-default-layout>
