<h3 style="text-align: center;">
    OPD: DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KOTA PEKALONGAN TAHUN @if($start_month->format('Y') == $end_month->format('Y')) {{ $start_month->format('Y') }} @else {{ $start_month->format('Y') }} -{{ $end_month->format('Y') }}  @endif
</h3>
<table>
    <thead>
        <tr>
            <th style="border: 1px solid black;">No.</th>
            <th style="border: 1px solid black;">Nama Pengadu</th>
            <th style="border: 1px solid black;">Isi Pengaduan</th>
            <th style="border: 1px solid black;">Tanggal Pengaduan</th>
            <th style="border: 1px solid black;">Tindak Lanjut Pengaduan</th>
            <th style="border: 1px solid black;">Tanggal Penyelesaian Pengaduan</th>
            <th style="border: 1px solid black;">Durasi atau Lama Penyelesaian Pengaduan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($aduan_perbulan as $bulan => $aduan)
            <tr>
                <td style="border: 1px solid black;background-color: lightblue;height:50px;font-weight: bold" colspan="7">
                    {{ $bulan }}
                </td>
            </tr>
            @foreach ($aduan as $ad)
                <tr>
                    <td style="border: 1px solid black;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->masyarakat ? $ad->masyarakat->name : 'Anonymous' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->uraian_pengaduan }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->tanggal_pengaduan }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->tindak_lanjut ? $ad->tindak_lanjut : $ad->text_direct_pengaduan ?? '-'}}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->tanggal_selesai ?? '-' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ $ad->tanggal_selesai ? \Carbon\Carbon::parse($ad->tanggal_selesai)->locale('id')->longAbsoluteDiffForHumans($ad->created_at) : '-' }}
                    </td>
                </tr>
            @endforeach
        @endforeach

        <tr>
            <td colspan="7" style="border: 1px solid black;">Total Pengaduan Masuk
                {{ $start_month->format('F Y') }} -
                {{ $end_month->format('F Y') }} : {{ $total_pengaduan }}
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;">
                Pekalongan, 23 September 2024
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;">
                Kepala Dinas Kependudukan
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;">
                dan Pencatatan Sipil Kota Pekalongan
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;height: 100px;">

            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;text-decoration: underline">
                SLAMET HARIYADI, S.H., M.HUM
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right;">
                NIP.19650204198603 1 016
            </td>
        </tr>
    </tbody>
</table>
