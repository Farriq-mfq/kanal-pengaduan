<h3 style="text-align: center;">
    OPD: DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL KOTA PEKALONGAN {{ $start_month->format('F Y') }} -
    {{ $end_month->format('F Y') }}
</h3>
<table>
    <thead>
        <tr>
            <th style="border: 1px solid black;width:50px">No.</th>
            <th style="border: 1px solid black;width:200px">Nama Pengadu</th>
            <th style="border: 1px solid black;width:200px">Isi Pengaduan</th>
            <th style="border: 1px solid black;width:200px">Tanggal Pengaduan</th>
            <th style="border: 1px solid black;width:200px">Tindak Lanjut Pengaduan</th>
            <th style="border: 1px solid black;width:200px">Tanggal Penyelesaian Pengaduan</th>
            <th style="border: 1px solid black;width:200px">Durasi atau Lama Penyelesaian Pengaduan</th>
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
                    <td style="border: 1px solid black;width:50px">
                        {{ $loop->iteration }}
                    </td>
                    <td style="border: 1px solid black;width:200px">
                        {{ $ad->masyarakat ? $ad->masyarakat->name : 'Anonymous' }}
                    </td>
                    <td style="border: 1px solid black;width:300px">
                        {{ $ad->uraian_pengaduan }}
                    </td>
                    <td style="border: 1px solid black;width:200px">
                        {{ $ad->tanggal_pengaduan }}
                    </td>
                    <td style="border: 1px solid black;width:200px">
                        {{ $ad->tindak_lanjut ? $ad->tindak_lanjut : $ad->text_direct_pengaduan ?? '-'}}
                    </td>
                    <td style="border: 1px solid black;width:200px">
                        {{ $ad->tanggal_selesai ? \Carbon\Carbon::parse($ad->tanggal_selesai)->locale('id')->format('Y/m/d') : '-' }}
                    </td>
                    <td style="border: 1px solid black;">
                        @php
                            $start = \Carbon\Carbon::parse($ad->tanggal_pengaduan);
                            $end = $ad->tanggal_selesai ? \Carbon\Carbon::parse($ad->tanggal_selesai) : null;
                            $diff = $end ? $start->diffInDays($end) : 0;
                        @endphp
                        @if ($end)
                            @if (floor($diff) == 0)
                                1 Hari
                                <!-- {{ $ad->created_at->diffForHumans($end) }} -->
                            @else
                                {{ floor($diff) }} Hari
                            @endif
                        @else
                            -
                        @endif
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
