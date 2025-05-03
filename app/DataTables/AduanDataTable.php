<?php

namespace App\DataTables;

use App\Models\Aduan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
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
                if ($aduan->status_aduan === 'menunggu') return 'status-background-warning';
                if ($aduan->status_aduan === 'proses') return 'status-background-info';
                if ($aduan->status_aduan === 'ditolak') return 'status-background-danger';
                if ($aduan->status_aduan === 'selesai') return 'status-background-success';
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
        return $model->newQuery();
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
        return [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->orderable(false)
                ->searchable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::make('tanggal_pengaduan')->title('Tanggal Pengaduan')->width(100),
            Column::make('nomer_aduan')->title('Nomor Aduan')->width(100),
            Column::make('tanggal_pengaduan')->title('Nama Pelapor')->width(150),
            Column::make('uraian_pengaduan')->title('Uraian Aduan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Aduan_' . date('YmdHis');
    }
}
