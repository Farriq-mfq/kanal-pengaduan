<?php

namespace App\DataTables;

use App\Models\Klasifikasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KlasifikasiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Klasifikasi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))
            ->setRowId('id')->addIndexColumn();

        if (auth()->user()->can('klasifikasi update') || auth()->user()->can('klasifikasi delete')) {
            $dataTable->addColumn('action', function (Klasifikasi $klasifikasi) {
                return view('pages.klasifikasi.columns._actions', compact('klasifikasi'));
            });
        }

        return $dataTable;
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Klasifikasi>
     */
    public function query(Klasifikasi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('klasifikasi-table')
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
        $columns = [
            Column::computed('DT_RowIndex')
                ->title('#')
                ->orderable(false)
                ->searchable(false)
                ->width(30)
                ->addClass('text-center'),
            Column::make('klasifikasi')->title('Klasifikasi'),
        ];


        if (auth()->user()->can('klasifikasi update') || auth()->user()->can('klasifikasi delete')) {
            $columns[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center');
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Klasifikasi_' . date('YmdHis');
    }
}
