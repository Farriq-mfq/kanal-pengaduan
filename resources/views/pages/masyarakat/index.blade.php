<x-default-layout title="Klasifikasi" :breadcrumbs="$breadcrumbs">

    <div class="card">
        <div class="card-body">
            <div class="row gap-5">
                <div class="col-12 justify-content-end d-flex">
                    <a href="{{ route('masyarakat.export') }}" type="button" class="btn btn-success"><i class="fas fa-download""></i> Download Data Masyarakat</a>
                </div>
                <div class=" col-12">
                            {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-default-layout>
