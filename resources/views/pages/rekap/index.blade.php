<x-default-layout title="Rekapitulasi Aduan" :breadcrumbs="$breadcrumbs">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <select name="jabatan" id="" class="form-control">
                                    <option value="">--Pilih Status Aduan--</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Download</button>
                            <button type="submit" class="btn btn-success">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
