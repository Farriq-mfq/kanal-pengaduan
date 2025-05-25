<x-default-layout title="Daftar Aduan" :breadcrumbs="$breadcrumbs">
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Aduan</p>
                                <h4 class="card-title" id="totalAduan"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Masyarakat</p>
                                <h4 class="card-title" id="totalMasyarakat"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Klasifikasi Aduan</p>
                                <h4 class="card-title" id="totalKlasifikasi"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pengguna Sistem</p>
                                <h4 class="card-title" id="totalPengguna"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">
                            Statistik Aduan Tahun {{ date('Y') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="chartStatusAduan"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Aduan Terbaru</div>
                        <div class="card-tools">
                            <a href="{{ route('aduan.index') }}" class="btn btn-sm btn-primary">Lihat semua</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Aduan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_aduan as $item)
                                    <tr>
                                        <th scope="row">
                                            <a href="{{ route('aduan.detail', $item->id) }}"
                                                class="text-secondary fw-bold">
                                                @if ($item->status_aduan == 'menunggu')
                                                    <span><i class="fa fa-clock text-warning me-2"></i> Menunggu</span>
                                                @elseif ($item->status_aduan == 'proses')
                                                    <span><i class="fa fa-info text-warning me-2"></i> Proses</span>
                                                @elseif($item->status_aduan == 'ditolak')
                                                    <span><i class="fa fa-times text-danger me-2"></i>Ditolak</span>
                                                @elseif($item->status_aduan == 'selesai')
                                                    <span><i class="fa fa-check text-success me-2"></i>Seleseai</span>
                                                @endif
                                                |
                                                #{{ $item->nomer_aduan }} @if ($item->klasifikasi)
                                                    - ({{ $item->klasifikasi }})
                                                @endif
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                const totalAduan = $('#totalAduan');
                const totalMasyarakat = $('#totalMasyarakat');
                const totalKlasifikasi = $('#totalKlasifikasi');
                const totalPengguna = $('#totalPengguna');

                totalAduan.text('Loading...');
                totalMasyarakat.text('Loading...');
                totalKlasifikasi.text('Loading...');
                totalPengguna.text('Loading...');

                $.get('{{ route('dashboard.json_stats_count') }}', function(data) {
                    totalAduan.text(data.total_pengaduan);
                    totalMasyarakat.text(data.total_masyarakat);
                    totalKlasifikasi.text(data.total_klasifikasi);
                    totalPengguna.text(data.total_users);
                }, 'json')

                const chartAduan = document.getElementById('chartStatusAduan');

                var ctx = chartAduan.getContext('2d');
                ctx.font = "30px Arial";
                ctx.fillText("Sedang Memuat  Grafik...", 10, 40, 300);

                $.get('{{ route('dashboard.json_stats_aduan') }}', function(data) {
                    const proses = Object.values(data.aduan_proses_perbulan)
                    const menunggu = Object.values(data.aduan_menunggu_perbulan)
                    const selesai = Object.values(data.aduan_selesai_perbulan)
                    const tolak = Object.values(data.aduan_tolak_perbulan)
                    var statisticsChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",
                                "Oct", "Nov",
                                "Dec"
                            ],
                            datasets: [{
                                    label: "Selesai",
                                    borderColor: '#28a745',
                                    pointBackgroundColor: 'rgba(40, 167, 69, 0.6)',
                                    pointRadius: 0,
                                    backgroundColor: 'rgba(40, 167, 69, 0.4)',
                                    legendColor: '#28a745',
                                    fill: true,
                                    borderWidth: 2,
                                    data: selesai
                                }, {
                                    label: "Menunggu",
                                    borderColor: '#fdaf4b',
                                    pointBackgroundColor: 'rgba(253, 175, 75, 0.6)',
                                    pointRadius: 0,
                                    backgroundColor: 'rgba(253, 175, 75, 0.4)',
                                    legendColor: '#fdaf4b',
                                    fill: true,
                                    borderWidth: 2,
                                    data: menunggu
                                },
                                {
                                    label: "Proses",
                                    borderColor: '#177dff',
                                    pointBackgroundColor: 'rgba(23, 125, 255, 0.6)',
                                    pointRadius: 0,
                                    backgroundColor: 'rgba(23, 125, 255, 0.4)',
                                    legendColor: '#177dff',
                                    fill: true,
                                    borderWidth: 2,
                                    data: proses
                                },
                                {
                                    label: "Tolak",
                                    borderColor: '#f3545d',
                                    pointBackgroundColor: 'rgba(243, 84, 93, 0.6)',
                                    pointRadius: 0,
                                    backgroundColor: 'rgba(243, 84, 93, 0.4)',
                                    legendColor: '#f3545d',
                                    fill: true,
                                    borderWidth: 2,
                                    data: tolak
                                },




                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                bodySpacing: 4,
                                mode: "nearest",
                                intersect: 0,
                                position: "nearest",
                                xPadding: 10,
                                yPadding: 10,
                                caretPadding: 10
                            },
                            layout: {
                                padding: {
                                    left: 5,
                                    right: 5,
                                    top: 15,
                                    bottom: 15
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        fontStyle: "500",
                                        beginAtZero: false,
                                        maxTicksLimit: 5,
                                        padding: 10
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        zeroLineColor: "transparent"
                                    },
                                    ticks: {
                                        padding: 10,
                                        fontStyle: "500"
                                    }
                                }]
                            },
                            legendCallback: function(chart) {
                                var text = [];
                                text.push('<ul class="' + chart.id + '-legend html-legend">');
                                for (var i = 0; i < chart.data.datasets.length; i++) {
                                    text.push('<li><span style="background-color:' + chart.data
                                        .datasets[i]
                                        .legendColor + '"></span>');
                                    if (chart.data.datasets[i].label) {
                                        text.push(chart.data.datasets[i].label);
                                    }
                                    text.push('</li>');
                                }
                                text.push('</ul>');
                                return text.join('');
                            }
                        }
                    });
                })

            })
        </script>
    @endpush
</x-default-layout>
