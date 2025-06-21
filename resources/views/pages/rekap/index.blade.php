<x-default-layout title="Rekapitulasi Aduan" :breadcrumbs="$breadcrumbs">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rekap.export') }}" method="get">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="month" name="start_month" class="form-control
                                @error('start_month')
                                    is-invalid
                                @enderror
                                ">
                                @error('start_month')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="month" name="end_month" class="form-control @error('end_month')
                                    is-invalid
                                @enderror ">
                                @error('end_month')
                                    <small class="form-text text-muted text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" name="type" value="download">Download</button>
                            <button type="submit" class="btn btn-success" name="type" value="cetak">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
