<x-front-layout title="Selamat Datang">
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
    @endpush
    <section class="hero">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Riwayat Aduan Saya
                    </h1>
                    <p>Informasi Pengaduan</p>
                </div>
            </div>
            <div class="row mt-4 justify-content-center" data-aos="zoom-out">
                <div style="overflow: scroll">
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomer Aduan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $("#datatable").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('front.aduan.data') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nomer_aduan',
                            name: 'nomer_aduan'
                        },
                        {
                            data: 'status_aduan',
                            name: 'status_aduan'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });
            })
        </script>
    @endpush
</x-front-layout>
