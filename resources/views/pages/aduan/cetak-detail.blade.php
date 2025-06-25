<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font: 12px Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path() . '/assets/img/kop.png')) }}"
        alt="kop" width="100%">
    <h1 style="text-align: center;text-transform:uppercase;text-decoration:underline">
        Laporan Pengaduan
    </h1>
    <br>
    <br>
    <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">Identias Pelapor</h2>
    <table style="width: fit;margin: 20px;font-weight:bold;border-collapse: collapse;">
        <tr style="font-size:16px;">
            <td style="padding:7px">Nama</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->masyarakat->name }}
            </td>
        </tr>
        <tr style="font-size:16px;">
            <td style="padding:7px">Nomer Aduan</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->nomer_aduan }}
            </td>
        </tr>
        <tr style="font-size:16px;">
            <td style="padding:7px">Tanggal Pengaduan</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->tanggal_pengaduan }}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">
        Uraian Pengaduan
    </h2>
    <p style="margin: 20px">
        {{ $aduan->uraian_pengaduan }}
    </p>
    <br>
    <br>
    @if ($aduan->kategori_id)
        <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">
            Unit Pelayanan Yang Menangani Pengaduan
        </h2>
        <table style="width: fit;margin: 20px;font-weight:bold;border-collapse: collapse;">
            <tr style="font-size:16px;">
                <td style="padding:7px">Unit Kerja</td>
                <td>
                    :&nbsp;
                </td>
                <td>
                    {{ $aduan->kategori->name }}
                </td>
            </tr>
            <tr style="font-size:16px;">
                <td style="padding:7px">Nama</td>
                <td>
                    :&nbsp;
                </td>
                <td>
                    {{ $aduan->kategori->user->name }}
                </td>
            </tr>
            <tr style="font-size:16px;">
                <td style="padding:7px">Jabatan</td>
                <td>
                    :&nbsp;
                </td>
                <td>
                    {{ $aduan->kategori->user->jabatan }}
                </td>
            </tr>
        </table>

    @endif
    <br>
    <br>
    <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">
        Klasifikasi dan Telaah Aduan
    </h2>
    <table style="width: fit;margin: 20px;font-weight:bold;border-collapse: collapse;">
        <tr style="font-size:16px;">
            <td style="padding:7px">Kecepatan Tindak Lanjut</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->kecepatan_tindak_lanjut ?? '-' }}
            </td>
        </tr>
        <tr style="font-size:16px;">
            <td style="padding:7px">Klasifikasi Aduan</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->klasifikasi ?? '-' }}
            </td>
        </tr>
        <tr style="font-size:16px;">
            <td style="padding:7px">Telaahan Aduan</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->telaah_aduan ?? '-' }}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">
        Tindak Lanjut Aduan
    </h2>
    <p style="margin: 20px">
        {{ $aduan->tindak_lanjut ? $aduan->tindak_lanjut : $aduan->text_direct_pengaduan ?? '-' }}
    </p>
    <br>
    <br>
    <h2 style="margin: 20px;text-transform: uppercase;text-decoration:underline">
        Status Aduan
    </h2>
    <table style="width: fit;margin: 20px;font-weight:bold;border-collapse: collapse;">
        <tr style="font-size:16px;">
            <td style="padding:7px">Status</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->status_aduan ?? '-' }}
            </td>
        </tr>
        <tr style="font-size:16px;">
            <td style="padding:7px">Tanggal Selesai</td>
            <td>
                :&nbsp;
            </td>
            <td>
                {{ $aduan->tanggal_selesai ? \Carbon\Carbon::parse($aduan->tanggal_selesai)->locale('id')->format('Y-m-d') : '-' }}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <span
        style="text-align: right;display: block;font-style: italic;font-size: 17px;margin:0 20px 50px;font-weight: bold">Pekalongan,
        {{ \Carbon\Carbon::now()->locale('id')->format('d F Y') }}</span>
    <span
        style="text-align: left;display: block;font-style: italic;font-size: 17px;margin:0 20px 10px;font-weight: bold">Mengetahui,</span>
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center;font-weight: bold">
                Kepala Dinas Kependudukan dan Pencatatan Sipil
            </td>
            <td style="text-align: center;font-weight: bold">
                Petugas Pengaduan
            </td>
            <td style="text-align: center;font-weight: bold">
                Pejabat Yang Menangani
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center;">
                {{ $aduan->kepala_dinas->name ?? '-' }}
            </td>
            <td style="text-align: center;">
                {{  '....' }}
            </td>
            <td style="text-align: center;">
                {{ $aduan->kepala_bidang->name ?? '-' }}
            </td>
        </tr>
    </table>
</body>

</html>
