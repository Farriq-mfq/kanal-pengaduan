<?php

namespace App\DataTables;

use App\Models\Aduan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AduanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Aduan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Aduan $aduan) {
                return view('pages.aduan.columns._actions', compact('aduan'));
            })
            ->editColumn('nomer_aduan', function (Aduan $aduan) {
                return view('pages.aduan.columns._nomer_aduan', compact('aduan'));
            })
            ->setRowClass(function (Aduan $aduan) {
                if ($aduan->status_aduan === 'menunggu')
                    return 'status-background-warning';
                if ($aduan->status_aduan === 'proses')
                    return 'status-background-info';
                if ($aduan->status_aduan === 'ditolak')
                    return 'status-background-danger';
                if ($aduan->status_aduan === 'selesai')
                    return 'status-background-success';
            })
            // ->editColumn('verifikasi_kepala_bidang', function (Aduan $aduan) {
            //     return view('pages.aduan.columns._verifikasi_kepala_bidang', compact('aduan'));
            // })
            ->editColumn('verifikasi_kepala_dinas', function (Aduan $aduan) {
                return view('pages.aduan.columns._verifikasi_kepala_dinas', compact('aduan'));
            })
            ->addColumn('nama_pelapor', function (Aduan $aduan) {
                return view('pages.aduan.columns._nama_pelapor', compact('aduan'));
            })
            ->editColumn('status_tindak_lanjut_kepala_bidang', function (Aduan $aduan) {
                return view('pages.aduan.columns._status_verifikasi_kepala_bidang', compact('aduan'));
            })
            ->setRowId('id')->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Aduan>
     */
    public function query(Aduan $model): QueryBuilder
    {
        $role = auth()->user()->role;
        if ($role != 'superAdmin') {
            if ($role == 'kepala bidang') {
                return $model
                    ->where('kepala_bidang_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->newQuery();
            } else if ($role == 'kepala dinas') {
                return $model
                    ->where('kepala_dinas_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->newQuery();
            } else if ($role === 'tim penanganan') {
                return $model
                    ->whereNot('status_aduan', "menunggu")
                    ->where('kategori_id', auth()->user()->kategori_id)
                    ->orderBy('id', 'desc')
                    ->newQuery();
            } else {
                return $model
                    ->orderBy('id', 'desc')
                    ->newQuery();
            }
        } else {
            return $model
                ->orderBy('id', 'desc')
                ->newQuery();
        }

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('aduan-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $role = auth()->user()->role;
        if ($role != 'superAdmin') {
            if ($role == 'kepala bidang') {
                return [
                    Column::computed('DT_RowIndex')
                        ->title('#')
                        ->orderable(false)
                        ->searchable(false)
                        ->width(30)
                        ->addClass('text-center'),
                    Column::make('tanggal_pengaduan')->title('Tanggal Pengaduan')->width(100),
                    Column::make('nama_pelapor')->title('Nama Pelapor')->width(100),
                    Column::make('nomer_aduan')->title('Nomor Aduan')->width(100),
                    Column::make('uraian_pengaduan')->title('Uraian Aduan'),
                    Column::make('status_tindak_lanjut_kepala_bidang')->title('Status Verifikasi Kepala Bidang'),
                    Column::make('verifikasi_kepala_dinas')->title('Status Verifikasi Kepala Dinas'),
                    Column::computed('action')
                        ->exportable(false)
                        ->printable(false)
                        ->width(60)
                        ->addClass('text-center'),
                ];
            } else if ($role == 'tim penanganan') {
                return [
                    Column::computed('DT_RowIndex')
                        ->title('#')
                        ->orderable(false)
                        ->searchable(false)
                        ->width(30)
                        ->addClass('text-center'),
                    Column::make('tanggal_pengaduan')->title('Tanggal Pengaduan')->width(100),
                    Column::make('nama_pelapor')->title('Nama Pelapor')->width(100),
                    Column::make('nomer_aduan')->title('Nomor Aduan')->width(100),
                    Column::make('uraian_pengaduan')->title('Uraian Aduan'),
                    Column::make('status_tindak_lanjut_kepala_bidang')->title('Status Verifikasi Kepala Bidang'),
                    Column::make('verifikasi_kepala_dinas')->title('Status Verifikasi Kepala Dinas'),
                    Column::computed('action')
                        ->exportable(false)
                        ->printable(false)
                        ->width(60)
                        ->addClass('text-center'),
                ];
            } else {
                return [
                    Column::computed('DT_RowIndex')
                        ->title('#')
                        ->orderable(false)
                        ->searchable(false)
                        ->width(30)
                        ->addClass('text-center'),
                    Column::make('tanggal_pengaduan')->title('Tanggal Pengaduan')->width(100),
                    Column::make('nama_pelapor')->title('Nama Pelapor')->width(100),
                    Column::make('nomer_aduan')->title('Nomor Aduan')->width(100),
                    Column::make('uraian_pengaduan')->title('Uraian Aduan'),
                    Column::make('status_tindak_lanjut_kepala_bidang')->title('Status Verifikasi Kepala Bidang'),
                    Column::make('verifikasi_kepala_dinas')->title('Status Verifikasi Kepala Dinas'),
                    Column::computed('action')
                        ->exportable(false)
                        ->printable(false)
                        ->width(60)
                        ->addClass('text-center'),
                ];
            }
        } else {
            return [
                Column::computed('DT_RowIndex')
                    ->title('#')
                    ->orderable(false)
                    ->searchable(false)
                    ->width(30)
                    ->addClass('text-center'),
                Column::make('tanggal_pengaduan')->title('Tanggal Pengaduan')->width(100),
                Column::make('nama_pelapor')->title('Nama Pelapor')->width(100),
                Column::make('nomer_aduan')->title('Nomor Aduan')->width(100),
                Column::make('uraian_pengaduan')->title('Uraian Aduan'),
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            ];
        }

    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Aduan_' . date('YmdHis');
    }
}
