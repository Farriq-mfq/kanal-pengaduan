<x-default-layout title="Daftar Aduan" :breadcrumbs="$breadcrumbs">
    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

        <script>
            $(document).ready(function() {
               $(document).on('click', '#copy_nomer_aduan', function() {
                   const nomerAduan = $(this).parent().find('#nomer_aduan').text();
                   navigator.clipboard.writeText(nomerAduan);
                   swal("Berhasil", "Nomer Aduan berhasil disalin", "success");
               })
            })
        </script>
    @endpush
</x-default-layout>
