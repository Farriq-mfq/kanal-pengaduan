@if (count($aduan->revisi) > 0)
    <table class="table table-bordered table-striped">
        <tr>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </tr>
        @foreach ($aduan->revisi as $revisi)
            <tr>
                <td>
                    {{ $revisi->keterangan }}
                </td>
                <td>
                    {{ $revisi->created_at->format('d F Y') }}
                </td>
            </tr>
        @endforeach

    </table>
@else
    <div>
        <p class="text-center">Belum ada revisi</p>
    </div>
@endif
